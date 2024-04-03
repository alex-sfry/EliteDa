<?php

namespace app\models;

use app\behaviors\TimeBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class TradeRoutes extends BaseCommodities
{
    private string $st_name;
    private string $sys_name;
    private array $post;
    private array $source_market = [];
    private array $dir_route_queries = [];
    private string $target_sys;
    private string $target_st;

    public function __construct(array $post)
    {
        $this->st_name = $post['ref_station'];
        $this->sys_name = $post['ref_system'];
        $this->post = $post;

        if (isset($post['targetSysStationName']) && $post['targetSysStation'] !== '') {
            if ($post['targetSysStationName'] === 'station') {
                $this->target_sys = StringHelper::explode($post['targetSysStation'], ' / ', true)[0];
                $this->target_st = StringHelper::explode($post['targetSysStation'], ' / ', true)[1];
            } else {
                $this->target_sys = $post['targetSysStation'];
            }
        }
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [TimeBehavior::class]
        );
    }

    /**
     * @param $limit
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getData($limit): ActiveDataProvider
    {
        switch ($this->post['sortBy']) {
            case 'Updated_at':
                $sort_attr = 'target_time_diff';
                $sort_order = 'asc';
                break;
            case 'Distance':
                $sort_attr = "distance_ly";
                $sort_order = 'asc';
                break;
            default:
                $sort_attr =  'dir_profit';
                $sort_order = 'desc';
        }

        $this->source_market = $this->getSourceMarket()->all();
        $tr_routes = $this->getTargetMarkets();

        return new ActiveDataProvider(config: [
            'query' => $tr_routes,
            'pagination' => [
                'pageSizeLimit' => [0, $limit],
                'defaultPageSize' => $limit,
            ],
            'sort' => [
                'attributes' => [
                    'dir_profit',
                    'distance_ly',
                    'target_time_diff'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order === 'asc' ? SORT_ASC : SORT_DESC
                ],
            ],
        ]);
    }

    /**
     * @return \yii\db\Query
     */
    private function getSourceMarket(): Query
    {
        return (new Query())
            ->select([
                'm.name AS commodity',
                'buy_price',
                'stock',
                'm.market_id',
                'type',
                'distance_to_arrival AS source_distance_ls',
                'TIMESTAMPDIFF(SECOND, TIMESTAMP, NOW()) as source_time_diff',
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['st.name' => $this->st_name, 'sys.name' => $this->sys_name])
            ->andWhere(['>', 'mean_price', 'buy_price'])
            ->andWhere(['>', 'stock', $this->post['minSupplyDemand']]);
    }

    /**
     * @return \yii\db\Query
     */
    private function getTargetMarkets(): Query
    {
        extract($this->getCoords($this->sys_name));
        $cargo = (int)$this->post['cargo'];

        foreach ($this->source_market as $item) {
            $query = (new Query())
                ->select([
                    new Expression("{$item['source_time_diff']} AS source_time_diff"),
                    new Expression("{$item['stock']} AS source_stock"),
                    new Expression("{$item['buy_price']} AS source_buy_price"),
                    new Expression(':type AS source_type', [':type' => $item['type']]),
                    new Expression("{$item['source_distance_ls']} AS source_distance_ls"),
                    'm.name AS commodity',
                    'st.name AS target_station',
                    'type AS target_type',
                    'distance_to_arrival AS target_distance_ls',
                    'sys.name AS target_system',
                    'sell_price AS target_sell_price',
                    'demand as target_demand',
                    'm.market_id AS target_market_id',
                    "(sell_price - {$item['buy_price']}) * $cargo AS dir_profit",
                    "ROUND(SQRT(POW((sys.x-$x), 2)+POW((sys.y-$y), 2)+POW((sys.z-$z), 2)), 2) as distance_ly",
                    'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) AS target_time_diff',
                ])
                ->from(['m' => 'markets'])
                ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
                ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
                ->where(['m.name' => $item['commodity']])
                ->andWhere(['>', 'demand', (int)$this->post['minSupplyDemand']])
                ->andWhere([
                    '>', "(sell_price - {$item['buy_price']}) * $cargo", $this->post['profit']
                ]);

            $this->post['landingPadSize'] === 'L' && $query->andWhere(['not', ['type' => 'Outpost']]);

            $this->post['includeSurface'] === 'No' &&
            $query->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

            $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$this->post['dataAge']} HOUR)");

            $this->post['dataAge'] !== 'Any' &&
            $query->andWhere(['>', 'timestamp', $date_sub_expr]);

            if (isset($this->post['targetSysStationName']) && $this->post['targetSysStation'] !== '') {
                $this->post['targetSysStationName'] === 'station' &&
                $query->andWhere(['st.name' => $this->target_st, 'sys.name' => $this->target_sys]);
                $this->post['targetSysStationName'] === 'system' &&
                $query->andWhere(['sys.name' => $this->target_sys]);
            } else {
                $this->post['maxDistanceFromRefStar'] !== 'Any' && $query->andWhere([
                    '<=',
                    "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2)",
                    $this->post['maxDistanceFromRefStar'],
                ]);

                $this->post['distanceFromStar'] !== 'Any' &&
                $query->andWhere(['<=', 'distance_to_arrival', $this->post['distanceFromStar']]);
            }

            $this->dir_route_queries[] = $query;
        }

        $query1 = array_shift($this->dir_route_queries);

        foreach ($this->dir_route_queries as $item) {
            $query1->union($item);
        }

        return (new Query())
            ->select('*')
            ->from($query1);
    }

    /**
     * @param $target_market_ids
     *
     * @return \yii\db\Query
     */
    public function getRoundTrip($target_market_ids): Query
    {
        $cargo = (int)$this->post['cargo'];
        $minSupplyDemand = (int)$this->post['minSupplyDemand'];

        $source_sell = (new Query())
            ->select(['m.name AS commodity', 'sell_price AS source_sell_price', 'demand AS source_demand'])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['m.market_id' => $this->source_market[0]['market_id']])
            ->andWhere(['>', 'sell_price', 'mean_price'])
            ->andWhere(['>', 'demand', $minSupplyDemand])
            ->all();

        $queries = [];
        foreach ($source_sell as $item) {
            $query = (new Query())
                ->select([
                    new Expression("{$item['source_sell_price']} AS source_sell_price"),
                    new Expression("{$item['source_demand']} AS source_demand"),
                    'm.name AS round_commodity',
                    'buy_price AS target_buy_price',
                    'stock AS target_stock',
                    'm.market_id AS target_market_id',
                    "({$item['source_sell_price']} - buy_price) * $cargo AS round_profit",
                ])
                ->from(['m' => 'markets'])
                ->where(['m.name' => $item['commodity']])
                ->andWhere(['>', 'stock', (int)$this->post['minSupplyDemand']])
                ->andWhere([
                    '>',
                    "({$item['source_sell_price']} - buy_price) * $cargo",
                    (int)$this->post['profit']
                ])
                ->andWhere(['m.market_id' => $target_market_ids]);

            $queries[] = $query;
        }

        $query1 = array_shift($queries);

        foreach ($queries as $item) {
            $query1->union($item, true);
        }

        return (new Query())
            ->select('*')
            ->from($query1);
    }

    /**
     * @param array $dir_data
     * @param array $round_trip_data
     *
     * @return array
     */
    public function getResultWithRoundTrip(array $dir_data, array $round_trip_data): array
    {
        $temp_arr = [];

        foreach ($round_trip_data as $item) {
            if (!ArrayHelper::keyExists($item['target_market_id'], $temp_arr)) {
                $temp_arr[$item['target_market_id']] = [
                    'round_profit' => $item['round_profit'],
                    'round_commodity' => $item['round_commodity'],
                    'source_sell_price' => $item['source_sell_price'],
                    'source_demand' => $item['source_demand'],
                    'target_buy_price' => $item['target_buy_price'],
                    'target_stock' => $item['target_stock'],
                ];
            }
        }

        $merged_arr = [];

        foreach ($dir_data as $key => $value) {
            if (ArrayHelper::keyExists($value['target_market_id'], $temp_arr)) {
                $merged_arr[] = ArrayHelper::merge($value, $temp_arr[$value['target_market_id']]);
            } else {
                $merged_arr[] = $value;
            }
        }

        return $merged_arr;
    }

    /**
     * @param array $models
     *
     * @return array
     */
    public function modifyModels(array $models): array
    {
        foreach ($models as $key => $value) {
            if (isset($value['round_commodity'])) {
                $value['round_commodity'] = $this->commodities[strtolower($value['round_commodity'])];
                $value['target']['buy_price'] = $value['target_buy_price'];
                $value['target']['stock'] = $value['target_stock'];
                $value['source']['sell_price'] = $value['source_sell_price'];
                $value['source']['demand'] = $value['source_demand'];
                $value['round_trip'] = true;
            } else {
                $value['round_trip'] = false;
            }

            $value['commodity'] = $this->commodities[strtolower($value['commodity'])];
            $value['source']['buy_price'] = $value['source_buy_price'];
            $value['source']['pad'] = $this->getLandingPadSizes()[$value['source_type']];
            $value['target']['pad'] = $this->getLandingPadSizes()[$value['target_type']];
            $value['source']['time_diff'] = $this->getTimeDiff($value['source_time_diff']);
            $value['target']['time_diff'] = $this->getTimeDiff($value['target_time_diff']);
            $value['source']['stock'] = $value['source_stock'];
            $value['target']['station'] = $value['target_station'];
            $value['source']['type'] = $value['source_type'];
            $value['target']['type'] = $value['target_type'];
            $value['target']['system'] = $value['target_system'];
            $value['source']['station'] = $this->st_name;
            $value['source']['system'] = $this->sys_name;
            $value['target']['distance_ls'] = $value['target_distance_ls'];
            $value['source']['distance_ls'] = $value['source_distance_ls'];

            $value['source']['surface'] = match ($value['source_type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };
            $value['target']['surface'] = match ($value['target_type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };

            $value['target']['sell_price'] = $value['target_sell_price'];
            $value['target']['demand'] = $value['target_demand'];
            $value['target']['market_id'] = $value['target_market_id'];

            unset($value['source_type']);
            unset($value['target_type']);
            unset($value['source_stock']);
            unset($value['target_station']);
            unset($value['target_system']);
            unset($value['target_distance_ls']);
            unset($value['target_sell_price']);
            unset($value['target_demand']);
            unset($value['target_market_id']);
            unset($value['source_time_diff']);
            unset($value['target_time_diff']);
            unset($value['target_buy_price']);
            unset($value['target_stock']);
            unset($value['source_sell_price']);
            unset($value['source_demand']);
            unset($value['source_distance_ls']);
            unset($value['source_buy_price']);
            unset($value['source_type']);
            unset($value['target_type']);

            $models[$key] = $value;
        }

        return $models;
    }
}
