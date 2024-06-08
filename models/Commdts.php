<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\helpers\Url;

class Commdts extends Model
{
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

    public function getPrices(array $get, int $limit): ActiveDataProvider
    {
        /** @var SystemBehavior|CommoditiesBehavior|Commdts $this */

        $distance_expr = $this->getDistanceToSystemExpression($get['refSystem']);
        $c_symbols = [];

        foreach ($this->commodities as $key => $value) {
            if (in_array($value, $get['commodities'])) {
                $c_symbols[] = $key;
            }
        }

        // price related vars depending on form data
        if ($get['buySellSwitch'] === 'buy') {
            $price_type = 'buy_price';
            $stock_demand = 'stock';
            $price_sort_direction = SORT_ASC;
        } else {
            $price_type = 'sell_price';
            $stock_demand = 'demand';
            $price_sort_direction = SORT_DESC;
        }

        $prices = (new Query())
            ->select([
                $price_type,
                $stock_demand,
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
            ->andWhere(['>', $stock_demand, 0]);

        $get['landingPadSize'] === 'L' && $prices->andWhere(['not', ['type' => 'Outpost']]);

        $get['includeSurface'] === 'No' &&
        $prices->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $get['distanceFromStar'] !== 'Any' &&
        $prices->andWhere(['<=', 'distance_to_arrival', $get['distanceFromStar']]);

        $get['maxDistanceFromRefStar'] !== 'Any' && $prices->andWhere([
            '<=',
            $distance_expr,
            $get['maxDistanceFromRefStar'],
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$get['dataAge']} HOUR)");

        $get['dataAge'] !== 'Any' &&
        $prices->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        switch ($get['sortBy']) {
            case 'Updated_at':
                $sort_attr = 'time_diff';
                $sort_order = SORT_ASC;
                break;
            case 'Distance':
                $sort_attr = "distance_ly";
                $sort_order = SORT_ASC;
                break;
            default:
                $sort_attr = $price_type;
                $sort_order = $price_sort_direction;
        }

        return new ActiveDataProvider(config: [
            'query' => $prices,
            'pagination' => [
                'pageSizeLimit' => [0, $limit],
                'defaultPageSize' => $limit,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'sell_price',
                    'buy_price'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order
                ],
            ],
        ]);
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
