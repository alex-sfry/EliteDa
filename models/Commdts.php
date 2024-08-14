<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\Url;

use function app\helpers\d;

class Commdts extends Model
{
    public ?array $commodities_arr = null;
    public ?string $refSystem = null;
    public ?string $landingPadSize = null;
    public ?string $includeSurface = null;
    public ?string $sortBy = null;
    public ?string $distanceFromStar = null;
    public ?string $minSupplyDemand = null;
    public ?string $buySellSwitch = null;
    public ?string $maxDistanceFromRefStar = null;
    public ?string $dataAge = null;
    public ?string $stock_demand = null;
    public ?string $price_type = null;
    public ?string $price_sort_direction = null;
    protected ?string $sort_attr = null;
    protected ?int $sort_order = null;
    protected int $limit = 0;
    protected array $order = [];
    protected int $offset = 0;
    protected ?array $commodities = null;

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                SystemBehavior::class,
                StationBehavior::class,
            ]
        );
    }

    public function setCommodities(array $commodities): void
    {
        $this->commodities = $commodities;
    }

    public function getPrices(): array
    {
        $query = $this->getQuery();
        $total_count = $query->count();

        if ($total_count === 0) {
            return [[], null, null];
        }

        $pagination = $this->getPaginationObj($total_count);

        $this->limit = $pagination->pageSize;
        $this->offset = $pagination->offset;

        $sort = $this->getSortObj();

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
                $this->sort_attr = 'time_diff';
                $this->sort_order = SORT_ASC;
                break;
            case 'Distance':
                $this->sort_attr = "distance_ly";
                $this->sort_order = SORT_ASC;
                break;
            default:
                $this->sort_attr = $this->price_type;
                $this->sort_order = $this->price_sort_direction;
        }

        return new Sort([
            'attributes' => [
                'distance_ly',
                'time_diff',
                'sell_price',
                'buy_price'
            ],
            'defaultOrder' => [
                $this->sort_attr => $this->sort_order
            ],
        ]);
    }

    protected function getQuery(): Query
    {
        /** @var SystemBehavior|CommoditiesBehavior|Commdts $this */

        $distance_expr = $this->getDistanceToSystemExpression($this->refSystem);
        $c_symbols = [];

        foreach ($this->commodities_arr as $item) {
            $c_symbols[] = array_search($item, $this->commodities);
        }

        $prices = (new Query())
            ->select([
                $this->price_type,
                $this->stock_demand,
                'm.name AS commodity',
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
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->where(['m.name' => $c_symbols])
            ->andWhere(['>', $this->stock_demand, 1]);

        $this->landingPadSize === 'L' && $prices->andWhere(['not', ['type' => 'Outpost']]);

        $this->includeSurface === 'No' &&
            $prices->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $this->distanceFromStar !== 'Any' &&
            $prices->andWhere(['<=', 'distance_to_arrival', $this->distanceFromStar]);

        if ($this->minSupplyDemand !== 'Any') {
            $this->buySellSwitch === 'buy' &&
                $prices->andWhere(['>=', 'stock', $this->minSupplyDemand]);
            $this->buySellSwitch === 'sell' &&
                $prices->andWhere(['>=', 'demand', $this->minSupplyDemand]);
        }

        $this->maxDistanceFromRefStar !== 'Any' && $prices->andWhere([
            '<=',
            $distance_expr,
            $this->maxDistanceFromRefStar,
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$this->dataAge} HOUR)");

        $this->dataAge !== 'Any' && $prices->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        return $prices;
    }

    public function modifyModels(array $models): array
    {
        /** @var StationBehavior|CommoditiesBehavior|Commdts $this */

        foreach ($models as $key => $value) {
            $value['commodity'] = isset($this->commodities[strtolower($value['commodity'])]) ?
                $this->commodities[strtolower($value['commodity'])] : $value['commodity'];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = Yii::$app->formatter->asRelativeTime($value['TIMESTAMP']);
            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };
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
}
