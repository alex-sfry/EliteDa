<?php

namespace app\models;

use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\ar\Shipyard;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\Url;

use function app\helpers\d;

class ShipyardShips extends Model
{
    /* properties for ship-modules page (ShipModules controller)  */
    public ?array $cMainSelect = null;
    public ?string $refSystem = null;
    public ?string $landingPadSize = null;
    public ?string $includeSurface = null;
    public ?string $sortBy = null;
    public ?string $distanceFromStar = null;
    public ?string $maxDistanceFromRefStar = null;
    public ?string $dataAge = null;
    public ?string $sort_attr = null;
    public ?int $sort_order = null;
    protected int $limit = 0;
    protected array $order = [];
    protected int $offset = 0;
    protected ?array $ships_arr = null;

    /* properties for station details page (Stations controller)  */
    public ?int $market_id = null;
    public ?string $sys_name = null;

    public function setShipsArr(array $ships_arr): void
    {
        $this->ships_arr = $ships_arr;
    }

    public function getShips(): array
    {

        $query = $this->getQuery();
        $total_count = $query->count();

        if ($total_count === 0) {
            return [[], null, null];
        }

        $pagination = $this->getPaginationObj($total_count);

        $this->limit = $pagination->pageSize;
        $this->offset = $pagination->offset;

        $sort = $sort = $this->getSortObj();
        $this->order = $sort->orders;

        $query->orderBy($this->order);
        $query->offset($this->offset);
        $query->limit($this->limit);

        return [
            $this->modifyModels($query->all()),
            $sort,
            $pagination
        ];
    }

    protected function getPaginationObj(int $total_count): Pagination
    {
        return new Pagination([
            'totalCount' => $total_count,
            'pageSizeLimit' => [0, 50],
            'defaultPageSize' => 50,
        ]);
    }

    protected function getSortObj(): Sort
    {
        switch ($this->sortBy) {
            case 'Updated_at':
                $sort_attr = 'time_diff';
                $sort_order = SORT_ASC;
                break;
            case 'Distance':
                $sort_attr = 'distance_ly';
                $sort_order = SORT_ASC;
                break;
            default:
                $sort_attr = 'distance_ly';
                $sort_order = SORT_ASC;
        }

        return new Sort([
            'attributes' => [
                'distance_ly',
                'time_diff'
            ],
            'defaultOrder' => [
                $sort_attr => $sort_order
            ],
        ]);
    }

    protected function getQuery(): Query
    {
        $this->attachBehavior('SystemBehavior', SystemBehavior::class);
        /** @var SystemBehavio|ShipyardShips $this */

        $distance_expr = $this->getDistanceToSystemExpression($this->refSystem);
        $mod_symbols = [];

        foreach ($this->ships_arr as $key => $value) {
            if (in_array($value, $this->cMainSelect)) {
                $mod_symbols[] = $key;
            }
        }

        $ships = (new Query())
            ->select([
                'sh.name AS ship',
                'st.name AS station',
                'st.id AS station_id',
                'type',
                'distance_to_arrival AS distance_ls',
                'systems.name AS system',
                'systems.id AS system_id',
                "$distance_expr AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['sh' => 'shipyard'])
            ->innerJoin(['st' => 'stations'], 'sh.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->where(['sh.name' => $mod_symbols]);

        $this->landingPadSize === 'L' && $ships->andWhere(['not', ['type' => 'Outpost']]);
        $this->includeSurface === 'No' &&
            $ships->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);
        $this->distanceFromStar !== 'Any' &&
            $ships->andWhere(['<=', 'distance_to_arrival', $this->distanceFromStar]);
        $this->maxDistanceFromRefStar !== 'Any' && $ships->andWhere([
            '<=',
            $distance_expr,
            $this->maxDistanceFromRefStar,
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$this->dataAge} HOUR)");

        $this->dataAge !== 'Any' &&
            $ships->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        return $ships;
    }

    public function modifyModels(array $models): array
    {
        $this->attachBehavior('StationBehavior', StationBehavior::class);
        /** @var StationBehavior|ShipyardShips $this */

        $sub_query = (new Query())
            ->select('name')
            ->from('ships_list')
            ->where(['ships_list.symbol' => $models[0]['ship']]);

        $ship_from_price_list = (new Query())
            ->select(['price'])
            ->from('ships_price_list')
            ->where(['ships_price_list.name' => $sub_query])
            ->one();

        foreach ($models as $key => $value) {
            $value['ship'] = isset($this->ships_arr[strtolower($value['ship'])]) ?
                $this->ships_arr[strtolower($value['ship'])] : $value['ship'];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = Yii::$app->formatter->asRelativeTime($value['TIMESTAMP']);
            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };
            $value['price'] = $ship_from_price_list ?
                Yii::$app->formatter->asInteger((int)$ship_from_price_list['price']) : null;
            $value['station'] = [
                'text' => $value['station'],
                'url' => Url::toRoute(["station/{$value['station_id']}"])
            ];
            $value['system'] = [
                'text' => $value['system'],
                'url' => Url::toRoute(["system/{$value['system_id']}"])
            ];

            $models[$key] = $value;
        }

        return $models;
    }

    public function getStationShips(): array
    {
        $ships = Shipyard::find()
            ->select([
                'sprc.name',
                'price',
                'timestamp',
            ])
            ->innerJoin(['slst' => 'ships_list'], 'slst.symbol = shipyard.name')
            ->innerJoin(['sprc' => 'ships_price_list'], 'sprc.name = slst.name')
            ->where(['market_id' => $this->market_id])
            ->orderBy('sprc.name')
            ->asArray()
            ->all();

        $this->attachBehavior('ShipyardShipsBehavior', ShipyardShipsBehavior::class);
        /** @var ShipyardShipsBehavior|ShipyardShips $this */

        foreach ($ships as $key => $value) {
            $ships[$key]['price'] = Yii::$app->formatter->asInteger((int)$value['price']);
            $ships[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);
            $ships[$key]['req_url'] = ArrayHelper::merge(
                ['shipyard-ships/index'],
                $this->getShipsReqArr([
                    'ship' => [$ships[$key]['name']],
                    'system' => $this->sys_name,
                ])
            );
        }

        return $ships;
    }
}
