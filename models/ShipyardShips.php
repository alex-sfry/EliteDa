<?php

namespace app\models;

use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\ar\Shipyard;
use yii\helpers\Url;

use function app\helpers\d;

class ShipyardShips extends Model
{
    private array $ships_arr = [];

    public function setShipsArr(array $ships_arr): void
    {
        $this->ships_arr = $ships_arr;
    }

    public function getShips(array $get, int $limit): ActiveDataProvider
    {
        $this->attachBehavior('SystemBehavior', SystemBehavior::class);
        $this->attachBehavior('StationBehavior', StationBehavior::class);

        /** @var SystemBehavior|StationBehavior|ShipyardShips $this */

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
                'systems.id AS system_id',
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

    public function modifyModels(array $models): array
    {
        /** @var StationBehavior|ShipyardShips $this */

        if (count($models) === 0) {
            return $models;
        }

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
            $value['system'] = [
                'text' => $value['system'],
                'url' => Url::toRoute(["system/{$value['system_id']}"])
            ];

            $models[$key] = $value;
        }

        return $models;
    }

    public function getStationShips(int $market_id, string $sys_name): array
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

        $this->attachBehavior('ShipyardShipsBehavior', ShipyardShipsBehavior::class);

        /** @var ShipyardShipsBehavior|ShipyardShips $this */

        foreach ($ships as $key => $value) {
            $ships[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);
            $ships[$key]['req_url'] = ArrayHelper::merge(
                ['shipyard-ships/index'],
                $this->getShipsReqArr([
                    'ship' => [$ships[$key]['name']],
                    'system' => $sys_name,
                ])
            );
        }

        return $ships;
    }
}
