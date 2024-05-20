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

class ShipMods extends Model
{
    private array $mods_arr = [];

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

    public function setMods(array $mods): void
    {
        $this->mods_arr = $mods;
    }

    /**
     * @param array $get
     * @param int $limit
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getModules(array $get, int $limit): ActiveDataProvider
    {
        $distance_expr = $this->getDistanceToSystemExpression($get['refSystem']);
        $mod_symbols = [];

        foreach ($this->mods_arr as $key => $value) {
            if (in_array($value, $get['cMainSelect'])) {
                $mod_symbols[] = $key;
            }
        }

        $mod_market = (new Query())
            ->select([
                'm.name AS module',
                'pl.price',
                'st.name AS station',
                'st.id AS station_id',
                'type',
                'distance_to_arrival AS distance_ls',
                'systems.name AS system',
                "$distance_expr AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'ship_modules'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->innerJoin(['pl' => 'modules_price_list'], 'm.name = pl.symbol')
            ->where(['m.name' => $mod_symbols]);

        $get['landingPadSize'] === 'L' && $mod_market->andWhere(['not', ['type' => 'Outpost']]);

        $get['includeSurface'] === 'No' &&
        $mod_market->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $get['distanceFromStar'] !== 'Any' &&
        $mod_market->andWhere(['<=', 'distance_to_arrival', $get['distanceFromStar']]);

        $get['maxDistanceFromRefStar'] !== 'Any' && $mod_market->andWhere([
            '<=',
            $distance_expr,
            $get['maxDistanceFromRefStar'],
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$get['dataAge']} HOUR)");

        $get['dataAge'] !== 'Any' &&
        $mod_market->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

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
                $sort_attr = 'module';
                $sort_order = SORT_ASC;
        }

        return new ActiveDataProvider(config: [
            'query' => $mod_market,
            'pagination' => [
                'pageSizeLimit' => [0, $limit],
                'defaultPageSize' => $limit,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'module'
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
        foreach ($models as $key => $value) {
            $value['module'] = isset($this->mods_arr[strtolower($value['module'])]) ?
                $this->mods_arr[strtolower($value['module'])] : $value['module'];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = Yii::$app->formatter->asRelativeTime($value['TIMESTAMP']);
            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };

            $models[$key] = $value;
        }

        return $models;
    }

    /**
     * @param int $market_id
     * @param string $cat
     *
     * @return array
     */
    public function getStationModules(int $market_id, string $cat): array
    {
        $market_id = (int)$market_id;

        $modules = (new Query())
            ->select([
                'ship_modules.name',
                'mlst.symbol',
                'category',
                'ship',
                'price',
                'timestamp',
                'market_id'
            ])
            ->from('ship_modules')
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->innerJoin(['mprc' => 'modules_price_list'], 'mprc.symbol = ship_modules.name')
            ->where(['market_id' => $market_id]);

        switch ($cat) {
            case 'armour':
                $modules->andWhere(['category' => 'standard']);
                $modules->andWhere(['like', 'ship_modules.name', 'Armour']);
                break;
            case 'core':
                $modules->andWhere(['category' => 'standard']);
                $modules->andWhere(['not like', 'ship_modules.name', '_Armour_']);
                break;
            case 'internal':
                $modules->andWhere(['category' => 'internal']);
                break;
            case 'utility':
                $modules->andWhere(['category' => 'utility']);
                break;
            case 'hardpoint':
                $modules->andWhere(['category' => 'hardpoint']);
                break;
            default:
                $modules->andWhere(['category' => 'hardpoint']);
        };

        $models = $modules->orderBy('ship_modules.name')->all();

        foreach ($models as $key => $value) {
            $models[$key]['m_name'] = isset($this->mods_arr[strtolower($value['name'])]) ?
                $this->mods_arr[strtolower($value['name'])] : $value['name'];
            $models[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);

            if (preg_match('/^.+_Armour_.+$/', $value['symbol'])) {
                $value['category'] = 'armour';
            }
        }

        return $models;
    }

    /**
     * @param int $market_id
     *
     * @return array
     */
    public function getQtyByCat(int $market_id): array
    {
        $market_id = (int)$market_id;

        $armour = ShipModules::find()
            ->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['like', 'ship_modules.name', 'Armour'])
            ->count();

        $hardpoint = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'hardpoint'])
            ->count();

        $core = ShipModules::find()
            ->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['not like', 'ship_modules.name', '_Armour_'])
            ->count();

        $internal = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'internal'])
            ->count();

        $utility = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'utility'])
            ->count();

        return [
            'hardpoint' => $hardpoint,
            'internal' => $internal,
            'utility' => $utility,
            'armour' => $armour,
            'core' => $core,
        ];
    }
}
