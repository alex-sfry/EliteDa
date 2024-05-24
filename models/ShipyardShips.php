<?php

namespace app\models;

use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\ar\Shipyard;

class ShipyardShips extends Model
{
    private array $ships_arr = [];

    /**
     * @return array
     */
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

    public function setShipsArr(array $ships_arr): void
    {
        $this->ships_arr = $ships_arr;
    }

    /**
     * @param array $get
     * @param int $limit
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getShips(array $get, int $limit): ActiveDataProvider
    {
        $distance_expr = $this->getDistanceToSystemExpression($get['refSystem']);
        $mod_symbols = [];

        foreach ($this->ships_arr as $key => $value) {
            if (in_array($value, $get['cMainSelect'])) {
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
                "$distance_expr AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['sh' => 'shipyard'])
            ->innerJoin(['st' => 'stations'], 'sh.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->where(['sh.name' => $mod_symbols]);

        $get['landingPadSize'] === 'L' && $ships->andWhere(['not', ['type' => 'Outpost']]);
        $get['includeSurface'] === 'No' &&
            $ships->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);
        $get['distanceFromStar'] !== 'Any' &&
            $ships->andWhere(['<=', 'distance_to_arrival', $get['distanceFromStar']]);
        $get['maxDistanceFromRefStar'] !== 'Any' && $ships->andWhere([
            '<=',
            $distance_expr,
            $get['maxDistanceFromRefStar'],
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$get['dataAge']} HOUR)");

        $get['dataAge'] !== 'Any' &&
            $ships->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

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
                $sort_attr = 'ship';
                $sort_order = SORT_ASC;
        }

        return new ActiveDataProvider(config: [
            'query' => $ships,
            'pagination' => [
                'pageSizeLimit' => [0, $limit],
                'defaultPageSize' => $limit,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'ship'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order
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
            $value['price'] = $ship_from_price_list ? $ship_from_price_list['price'] : null;
            $value['station'] = [
                'text' => $value['station'],
                'url' => Url::toRoute(["station/{$value['station_id']}"])
            ];

            $models[$key] = $value;
        }

        return $models;
    }

    public function getStationShips(int $market_id): array
    {
        $market_id = (int)$market_id;

        $ships = Shipyard::find()
            ->select([
                'sprc.name',
                'price',
                'timestamp',
            ])
            ->innerJoin(['slst' => 'ships_list'], 'slst.symbol = shipyard.name')
            ->innerJoin(['sprc' => 'ships_price_list'], 'sprc.name = slst.name')
            ->where(['market_id' => $market_id])
            ->orderBy('sprc.name')
            ->asArray()
            ->all();

        foreach ($ships as $key => $value) {
            $ships[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);
        }

        return $ships;
    }
}
