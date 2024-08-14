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
    public array $commodities_arr;
    public string $refSystem;
    public string $landingPadSize;
    public string $includeSurface;
    public string $distanceFromStar;
    public string $minSupplyDemand;
    public string $buySellSwitch;
    public string $maxDistanceFromRefStar;
    public string $dataAge;
    public string $price_type;
    public string $stock_demand;
    public string $sort_attr;
    public int $sort_order;
    protected int $limit = 0;
    protected array $order = [];
    protected int $offset = 0;

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                CommoditiesBehavior::class,
                SystemBehavior::class,
                StationBehavior::class,
            ]
        );
    }

    public function getPrices(): array
    {
        $query = $this->getQuery();
        $total_count = $query->count();

        if ($total_count === 0) {
            return [[], null, null];
        }

        $pagination = new Pagination([
            'totalCount' => $total_count,
            'pageSizeLimit' => [0, 50],
            'defaultPageSize' => 50,
        ]);

        $this->limit = $pagination->pageSize;
        $this->offset = $pagination->offset;

        $sort = new Sort([
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

    protected function getQuery(): Query
    {
        /** @var SystemBehavior|CommoditiesBehavior|Commdts $this */

        $distance_expr = $this->getDistanceToSystemExpression($this->refSystem);
        $c_symbols = [];

        foreach ($this->commodities_arr as $item) {
            $c_symbols[] = array_search($item, $this->getCommodities());
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
