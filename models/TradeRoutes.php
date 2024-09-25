<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\StringHelper;

use function app\helpers\d;

class TradeRoutes extends Model
{
    protected $min_supply_demand;
    protected int $cargo;
    protected int $profit;
    protected int $max_distance;
    protected Expression $distance_expr;
    protected bool $check_round_trip = false;
    protected string $st_name;
    protected string $sys_name;
    protected string $target_sys;
    protected string $target_st;
    protected string $pad;
    protected string $incl_surface;
    protected $dta;
    protected string $data_age;

    public function __construct(array $get)
    {
        $this->st_name = $get['ref_station'];
        $this->sys_name = $get['ref_system'];
        $this->min_supply_demand = $get['minSupplyDemand'];
        $this->cargo = $get['cargo'];
        $this->profit = $get['profit'];
        $this->max_distance = $get['maxDistanceFromRefStar'];
        $this->pad = $get['landingPadSize'];
        $this->incl_surface = $get['includeSurface'];
        $this->dta = $get['distanceFromStar'];
        $this->data_age = $get['dataAge'];

        if (isset($get['roundTrip'])) {
            $this->check_round_trip = true;
        }

        if (isset($get['targetSysStationName']) && $get['targetSysStation'] !== '') {
            if ($get['targetSysStationName'] === 'station') {
                $this->target_sys = StringHelper::explode($get['targetSysStation'], ' / ', true)[0];
                $this->target_st = Html::decode(StringHelper::explode($get['targetSysStation'], ' / ', true)[1]);
            } else {
                $this->target_sys = $get['targetSysStation'];
            }
        }
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                SystemBehavior::class,
                CommoditiesBehavior::class,
                StationBehavior::class
            ]
        );
    }

    public function getTradeRoutes(): array
    {
        /** @var SystemBehavior|StationBehavior|TradeRoutes $this */

        $this->distance_expr = $this->getDistanceToSystemExpression($this->sys_name);
        $source_station = $this->getSourceStation($this->sys_name, $this->st_name);

        if (!$source_station) {
            return [];
        }

        $source_market = $this->getSourceMarketQuery((int)$source_station['market_id']);
        $target_markets = $this->getTargetMarkets($source_market);

        if ($this->check_round_trip) {
            $round_trips = $this->calcRoundTrip($target_markets, $source_station);
        } else {
            $round_trips = [];
        }

        $models = $this->modifyModels($target_markets, $round_trips);
        $source_station['pad'] = $this->getLandingPadSizes()[$source_station['type']];
        $models['source_station'] = $source_station;

        return $models;
    }

    protected function removeDuplicates(array $arr, string $key): array
    {
        $uniqueCommodities = [];
        $unique_arr = [];

        foreach ($arr as $item) {
            if (!in_array(strtolower($item[$key]), $uniqueCommodities)) {
                $uniqueCommodities[] = strtolower($item[$key]);
                $item[$key] = strtolower($item[$key]);
                $unique_arr[] = $item;
            }
        }

        unset($uniqueCommodities);

        return $unique_arr;
    }

    protected function getSourceStation(): array|bool
    {
        return (new Query())
            ->from('stations st')
            ->select([
                'st.name AS station',
                'st.type',
                'st.distance_to_arrival as dta',
                'st.market_id',
                'sys.name AS system',
                'st.id AS station_id',
                'system_id'
            ])
            ->innerJoin(['sys' => 'systems'], 'sys.id = st.system_id')
            ->where(['sys.name' => $this->sys_name, 'st.name' => $this->st_name])
            ->cache(86400)
            ->one();
    }

    protected function getSourceMarketQuery(int $market_id): Query
    {
        return (new Query())
            ->select([
                'm1.buy_price AS source_buy_price',
                'm1.stock AS source_stock',
                'm1.name AS source_commodity',
                'm1.timestamp AS source_timestamp'
            ])
            ->from(['m1' => 'markets'])
            ->where(['m1.market_id' => $market_id])
            ->andWhere('m1.buy_price < mean_price')
            ->andWhere('m1.buy_price > 0')
            ->andWhere(['>=', 'm1.stock', $this->min_supply_demand])
            ->andWhere(['>', 'm1.stock', 1]);
    }

    protected function getSystemsInRadius(): array
    {
        return (new Query())
            ->select(['id'])
            ->from(['systems'])
            ->where(['<=', $this->distance_expr, $this->max_distance])
            ->cache(86400)
            ->all();
    }

    protected function getTargetMarkets(Query $source_market): array
    {
        $query =
            (new Query())
                ->select([
                    'm2.name AS commodity',
                    'source_buy_price',
                    'source_stock',
                    'm2.sell_price AS target_sell_price',
                    'm2.demand AS target_demand',
                    'm2.market_id AS target_market_id',
                    'm2.timestamp AS target_timestamp',
                    'source_timestamp',
                    'st.name AS target_station',
                    'st.id AS target_station_id',
                    'type AS target_type',
                    'distance_to_arrival AS target_dta',
                    'systems.name AS target_system',
                    'systems.id AS target_system_id',
                    "(m2.sell_price - sm.source_buy_price) * $this->cargo AS profit",
                    "$this->distance_expr AS distance",
                ])
                ->from(['m2' => 'markets'])
                ->innerJoin(['sm' => $source_market], 'sm.source_commodity = m2.name')
                ->innerJoin(['st' => 'stations'], 'st.market_id = m2.market_id')
                ->innerJoin(['systems'], 'systems.id = st.system_id')
                ->where(['systems.id' => ArrayHelper::getColumn($this->getSystemsInRadius(), 'id')])
                ->andWhere('sell_price > mean_price')
                ->andWhere(['>=', 'demand', $this->min_supply_demand])
                ->andWhere(['>', 'demand', 1])
                ->andWhere(['>', "(m2.sell_price - sm.source_buy_price) * {$this->cargo}", $this->profit]);

        $this->data_age !== 'Any' && $query->andWhere([
            '>', 'm2.timestamp', new Expression("DATE_SUB(NOW(), INTERVAL {$this->data_age} HOUR)")
        ]);

        if (!isset($this->target_st)) {
            $this->pad === 'L' && $query->andWhere(['not', ['type' => 'Outpost']]);

            $this->incl_surface === 'No' &&  $query->andWhere([
                    'not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']
                ]);

            $this->dta !== 'Any' && $query->andWhere([
                '<=', 'distance_to_arrival', $this->dta
            ]);
        }

        if (isset($this->target_st) && $this->target_st) {
            $query->andWhere(['st.name' => $this->target_st, 'systems.name' => $this->target_sys]);
        } elseif (isset($this->target_sys) && $this->target_sys) {
            $query->andWhere(['systems.name' => $this->target_sys]);
        }

        $target_markets = $query->cache(60)->all();
        ArrayHelper::multisort($target_markets, ['profit'], [SORT_DESC]);
        $dir_routes = $this->removeDuplicates($target_markets, 'commodity');

        if (!$this->check_round_trip) {
            unset($target_markets);
        }

        return $dir_routes;
    }

    protected function getSourceMarkeRoundQuery(array $source_station): Query
    {
        return (new Query())
            ->select([
                'sell_price AS source_sell_price_round',
                'demand AS source_demand_round',
                'm.name AS source_commodity_round',
            ])
            ->from(['m' => 'markets'])
            ->where(['m.market_id' => $source_station['market_id']])
            ->andWhere('sell_price > mean_price')
            ->andWhere(['>=', 'm.demand', $this->min_supply_demand])
            ->andWhere(['>', 'm.demand', 1]);
    }

    protected function calcRoundTrip(array $target_markets, array $source_station): array
    {
        $ids = ArrayHelper::getColumn($target_markets, 'target_market_id');

        $source_market_round = $this->getSourceMarkeRoundQuery($source_station);

        $round_markets =
            (new Query())
                ->select([
                    'mr.name AS commodity_round',
                    'mr.buy_price AS target_buy_price_round',
                    'mr.stock AS target_stock_round',
                    'mr.market_id AS target_market_id_round',
                    'mr.timestamp AS target_timestamp_round',
                    'source_sell_price_round',
                    'source_demand_round',
                    "(source_sell_price_round - mr.buy_price) * {$this->cargo} AS profit_round",
                    ])
                ->from(['mr' => 'markets'])
                ->innerJoin(['sm' => $source_market_round], 'sm.source_commodity_round = mr.name')
                ->where(['mr.market_id' => $ids])
                ->andWhere('mr.buy_price < mr.mean_price')
                ->andWhere('mr.buy_price > 0')
                ->andWhere(['>=', 'mr.stock', $this->min_supply_demand])
                ->andWhere(['>', 'mr.stock', 1])
                ->cache(60)
                ->all();

        ArrayHelper::multisort($round_markets, ['profit_round'], [SORT_DESC]);
        unset($target_markets);

        return $round_markets;
    }

    protected function modifyModels(array $target_markets, array $round_trips = []): array
    {
        /** @var CommoditiesBehavior|StationBehavior|TradeRoutes $this */

        $models = [];

        if (count($round_trips) > 0) {
            foreach ($target_markets as $k => $market) {
                foreach ($round_trips as $trip) {
                    if ($market['target_market_id'] === $trip['target_market_id_round']) {
                        $models[] = ArrayHelper::merge($market, $trip);
                        break;
                    }
                }

                if (!isset($models[$k])) {
                    $models[] = $market;
                }
            }
        } else {
            $models = $target_markets;
        }

        foreach ($models as $key => $value) {
            if (isset($value['commodity_round'])) {
                $value['commodity_round'] = isset($this->commodities[strtolower($value['commodity_round'])]) ?
                    $this->commodities[strtolower($value['commodity_round'])] : $value['commodity_round'];
            }

            $value['commodity'] = isset($this->commodities[strtolower($value['commodity'])]) ?
                $this->commodities[strtolower($value['commodity'])] : $value['commodity'];

            $value['source_time_diff'] = Yii::$app->formatter->asRelativeTime($value['source_timestamp']);
            $value['target_time_diff'] = Yii::$app->formatter->asRelativeTime($value['target_timestamp']);
            $value['target_pad'] = $this->getLandingPadSizes()[$value['target_type']];

            $models[$key] = $value;
        }

        return $models;
    }
}
