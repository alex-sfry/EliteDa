<?php

namespace app\models;

use app\behaviors\TimeBehavior;
use app\behaviors\ShipModulesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\helpers\VarDumper;

class ShipMods extends Model
{
    private array $mods_arr = [];

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                TimeBehavior::class,
                // ShipModulesBehavior::class,
                SystemBehavior::class,
                StationBehavior::class,
            ]
        );
    }

    public function __construct($mods)
    {
        $this->mods_arr = $mods;
    }

    /**
     * @param string $sys_name
     * @param array $post
     * @param int $limit
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getModules(string $sys_name, array $post, int $limit): ActiveDataProvider
    {
        extract($this->getCoords($sys_name));
        $mod_symbols = [];

        foreach ($this->mods_arr as $key => $value) {
            if (in_array($value, $post['cMainSelect'])) {
                $mod_symbols[] = $key;
            }
        }

        $modules = (new Query())
            ->select([
                // $price_type,
                // $stock_demand,
                'm.name AS module',
                'st.name AS station',
                'type',
                'distance_to_arrival AS distance_ls',
                'sys.name AS system',
                "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2) AS distance_ly",
                'TIMESTAMPDIFF(SECOND, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'ship_modules'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['m.name' => $mod_symbols])
            // ->andWhere(['>', $stock_demand, 0])
            ;

        $post['landingPadSize'] === 'L' && $modules->andWhere(['not', ['type' => 'Outpost']]);

        $post['includeSurface'] === 'No' &&
        $modules->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $post['distanceFromStar'] !== 'Any' &&
        $modules->andWhere(['<=', 'distance_to_arrival', $post['distanceFromStar']]);

        $post['maxDistanceFromRefStar'] !== 'Any' && $modules->andWhere([
            '<=',
            "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2)",
            $post['maxDistanceFromRefStar'],
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$post['dataAge']} HOUR)");

        $post['dataAge'] !== 'Any' &&
        $modules->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

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
                $sort_attr = 'module';
                $sort_order = 'asc';
        }

        return new ActiveDataProvider(config: [
            'query' => $modules,
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
                    $sort_attr => $sort_order === 'asc' ? SORT_ASC : SORT_DESC
                ],
            ],
        ]);
    }

    /**
     * @param array $models
     *
     * @return array
     */
    public function modifyModels(array $models, array $post): array
    {
        // VarDumper::dump(array_intersect($this->mods_arr, $post['cMainSelect']), 10, true);
        // VarDumper::dump($this->mods_arr, 10, true);

        // $this->mods_arr = array_change_key_case($this->mods_arr);

        foreach ($models as $key => $value) {
            $value['module'] = $this->mods_arr[strtolower($value['module'])];
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
