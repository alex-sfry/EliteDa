<?php

namespace app\models;

use app\behaviors\ShipModulesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\ar\ShipModules;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\Url;

class ShipMods extends Model
{
    /* properties for ship-modules page (ShipModules controller)  */
    public ?array $cMainSelect = null;
    public ?string $refSystem = null;
    public ?string $landingPadSize = null;
    public ?string $includeSurface = null;
    public ?string $sortBy = null;
    public ?string $distanceFromStar = null;
    public ?string $maxDistanceFromRefStar = null;
    public ?string $dataAge = null;
    public ?string $sort_attr = null;
    public ?int $sort_order = null;
    protected int $limit = 0;
    protected array $order = [];
    protected int $offset = 0;
    protected ?array $mods_arr = null;

    /* properties for station details page (Stations controller)  */
    public ?int $market_id = null;
    public ?string $cat = null;
    public ?string $sys_name = null;

    public function setMods(array $mods): void
    {
        $this->mods_arr = $mods;
    }

    public function getModules(): array
    {
        $query = $this->getQuery();
        $total_count = $query->count();

        if ($total_count === 0) {
            return [[], null, null];
        }

        $pagination = $this->getPaginationObj($total_count);

        $this->limit = $pagination->pageSize;
        $this->offset = $pagination->offset;

        $sort = $sort = $this->getSortObj();
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

        return new Sort([
            'attributes' => [
                'distance_ly',
                'time_diff',
                'module'
            ],
            'defaultOrder' => [
                $sort_attr => $sort_order
            ],
        ]);
    }

    protected function getQuery(): Query
    {
        $this->attachBehavior('SystemBehavior', SystemBehavior::class);
        /** @var SystemBehavior|ShipMods $this */

        $distance_expr = $this->getDistanceToSystemExpression($this->refSystem);
        $mod_symbols = [];

        foreach ($this->cMainSelect as $item) {
            $mod_symbols[] = array_search($item, $this->mods_arr);
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
                'systems.id AS system_id',
                "$distance_expr AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'ship_modules'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->innerJoin(['pl' => 'modules_price_list'], 'm.name = pl.symbol')
            ->where(['m.name' => $mod_symbols]);

        $this->landingPadSize === 'L' && $mod_market->andWhere(['not', ['type' => 'Outpost']]);

        $this->includeSurface === 'No' &&
            $mod_market->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $this->distanceFromStar !== 'Any' &&
            $mod_market->andWhere(['<=', 'distance_to_arrival', $this->distanceFromStar]);

        $this->maxDistanceFromRefStar !== 'Any' && $mod_market->andWhere([
            '<=',
            $distance_expr,
            $this->maxDistanceFromRefStar,
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$this->dataAge} HOUR)");

        $this->dataAge !== 'Any' && $mod_market->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        return $mod_market;
    }

    protected function modifyModels(array $models): array
    {
        $this->attachBehavior('SystemBehavior', StationBehavior::class);
        /** @var StationBehavior|ShipMods $this */

        foreach ($models as $key => $value) {
            $value['price'] = Yii::$app->formatter->asInteger((int)$value['price']);
            $value['module'] = isset($this->mods_arr[strtolower($value['module'])]) ?
                $this->mods_arr[strtolower($value['module'])] : $value['module'];
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

    public function getStationModules(): array
    {
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
            ->where(['market_id' => $this->market_id]);

        switch ($this->cat) {
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

        $this->attachBehavior('ShipModulesBehavior', ShipModulesBehavior::class);

        /** @var ShipModulesBehavior|ShipMods $this */

        foreach ($models as $key => $value) {
            $models[$key]['price'] = Yii::$app->formatter->asInteger((int)$value['price']);
            $models[$key]['m_name'] = isset($this->mods_arr[strtolower($value['name'])]) ?
                $this->mods_arr[strtolower($value['name'])] : $value['name'];
            $models[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);

            if (preg_match('/^.+_Armour_.+$/', $value['symbol'])) {
                $value['category'] = 'armour';
            }

            $models[$key]['req_url'] = ArrayHelper::merge(
                ['ship-modules/index'],
                $this->getShipModulesReqArr([
                    'module' => [$models[$key]['m_name']],
                    'system' => $this->sys_name,
                ])
            );
        }

        return $models;
    }

    public function getQtyByCat(): array
    {
        $armour = ShipModules::find()
            ->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $this->market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['like', 'ship_modules.name', 'Armour'])
            ->count();

        $hardpoint = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $this->market_id])
            ->andWhere(['category' => 'hardpoint'])
            ->count();

        $core = ShipModules::find()
            ->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $this->market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['not like', 'ship_modules.name', '_Armour_'])
            ->count();

        $internal = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $this->market_id])
            ->andWhere(['category' => 'internal'])
            ->count();

        $utility = ShipModules::find()
            ->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $this->market_id])
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
