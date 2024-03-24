<?php

namespace app\models;

use app\behaviors\TimeBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Commdts extends BaseCommodities
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [TimeBehavior::class]
        );
    }

    /**
     * @param string $sys_name
     * @param array $post
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getPrices(string $sys_name, array $post): ActiveDataProvider
    {
        extract($this->getCoords($sys_name));
        $c_symbols = [];

        foreach ($this->commodities as $key => $value) {
            if (in_array($value, $post['commodities'])) {
                $c_symbols[] = $key;
            }
        }

        // price related vars depending on form data
        if ($post['buySellSwitch'] === 'buy') {
            $price_type = 'buy_price';
            $stock_demand = 'stock';
            $price_sort_direction = 'asc';
        } else {
            $price_type = 'sell_price';
            $stock_demand = 'demand';
            $price_sort_direction = 'desc';
        }

        $prices = (new Query())
            ->select([
                $price_type,
                $stock_demand,
                'm.name AS commodity',
                'st.name AS station',
                'type',
                'distance_to_arrival AS distance_ls',
                'sys.name AS system',
                "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2) AS distance_ly",
                'TIMESTAMPDIFF(SECOND, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['m.name' => $c_symbols])
            ->andWhere(['>', $stock_demand, 0]);

        $post['landingPadSize'] === 'L' && $prices->andWhere(['not', ['type' => 'Outpost']]);

        $post['includeSurface'] === 'No' &&
        $prices->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $post['distanceFromStar'] !== 'Any' &&
        $prices->andWhere(['<=', 'distance_to_arrival', $post['distanceFromStar']]);

        $post['maxDistanceFromRefStar'] !== 'Any' && $prices->andWhere([
            '<=',
            "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2)",
            $post['maxDistanceFromRefStar'],
        ]);

        $post['dataAge'] !== 'Any' && $prices->andWhere(['>', 'TIMESTAMP', "DATE_SUB(NOW(), {$post['dataAge']} HOUR"]);

        switch ($post['sortBy']) {
            case 'Updated_at':
                $sort_attr = 'time_diff';
                $sort_order = 'asc';
                break;
            case 'Distance':
                $sort_attr = "distance_ly";
                $sort_order = 'asc';
                break;
            default:
                $sort_attr = $price_type;
                $sort_order = $price_sort_direction;
        }

        return new ActiveDataProvider(config: [
            'query' => $prices,
            'pagination' => [
                'pageSizeLimit' => [0, 100],
                'defaultPageSize' => 100,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'sell_price',
                    'buy_price'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order === 'asc' ? SORT_ASC : SORT_DESC,
                ],
            ],
        ]);
    }

    /**
     * @param array $models
     *
     * @return array
     */
    public function modifyModels(array $models): array
    {
        foreach ($models as $key => $value) {
            $value['commodity'] = $this->commodities[strtolower($value['commodity'])];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = $this->getTimeDiff($value['time_diff']);

            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };
            $models[$key] = $value;
        }

        return $models;
    }
}
