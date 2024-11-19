<?php

namespace app\services;

use app\models\ar\ModulesPriceList;
use app\models\ar\ShipModules;
use app\traits\ShipModulesTrait;
use app\traits\StationConditionsTrait;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Expression;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;

class ShipModulesService
{
    use ShipModulesTrait;
    use StationConditionsTrait;

    public ?array $form = null;
    public ?array $modules_list = null;

    public function __construct(array $form = null)
    {
        $this->form = $form;
        $this->modules_list = $this->getShipModules();
    }

    /**
     * @throws InvalidConfigException
     */
    public function findModules(): ActiveQuery
    {
        if (!is_array($this->form)) {
            throw new InvalidConfigException();
        }

        $sys_service = new SystemsService();
        $distance_expr = $sys_service->distanceExpr($this->form['refSystem']);

        $price = ModulesPriceList::find()
            ->select('price')
            ->where(['symbol' => $this->form['cMainSelect']])
            /* ->cache(86400) */
            ->one();

        return ShipModules::find()
            ->select([
                'ship_modules.*',
                "IF(type!='Outpost','L','M') as pad",
                "IF(type IN ('Planetary Outpost', 'Planetary Port', 'Odyssey Settlement'),TRUE,FALSE) as surface",
                "$distance_expr as distance",
                "timestamp"
            ])
            ->modules($this->form['cMainSelect'])
            ->filter([
                'distanceFromStar' => $this->form['distanceFromStar'],
                'surface' => $this->surfaceCondition($this->form['includeSurface']),
                'pad' => $this->padCondition($this->form['landingPadSize'])
            ]);
    }

    public function stationModules(int $market_id, string $cat, string $sys_name): array
    {
        $modules = ShipModules::find()
            ->select([
                'ship_modules.name',
                'mlst.symbol',
                'category',
                'ship',
                'price',
                'timestamp',
                'market_id'
            ])
            ->stationModules($market_id, $cat);

        $models = $modules->orderBy('ship_modules.name')->asArray()/* ->cache(60 */)->all();
        foreach ($models as $key => $value) {
            $models[$key]['req_url'] = ArrayHelper::merge(
                ['ship-modules/index'],
                $this->getShipModulesReqArr([
                    'module' => [$models[$key]['name']],
                    'system' => $sys_name,
                ])
            );

            $models[$key]['price'] = \Yii::$app->formatter->asInteger((int)$value['price']);
            $models[$key]['m_name'] = isset($this->modules_list[strtolower($value['name'])]) ?
                $this->modules_list[strtolower($value['name'])] : $value['name'];
            $models[$key]['timestamp'] = \Yii::$app->formatter->asRelativeTime($value['timestamp']);

            if (preg_match('/^.+_Armour_.+$/', $value['symbol'])) {
                $value['category'] = 'armour';
            }

            $models[$key]['req_url'] = ArrayHelper::merge(
                ['ship-modules/index'],
                $this->getShipModulesReqArr([
                    'module' => [$models[$key]['name']],
                    'system' => $sys_name,
                ])
            );
        }

        return $models;
    }

    public function qtyByCat(int $market_id): array
    {
        return [
            'armour' => ShipModules::find()->armour($market_id)/* ->cache(60) */->count(),
            'hardpoint' => ShipModules::find()->hardpoint($market_id)/* ->cache(60) */->count(),
            'core' => ShipModules::find()->core($market_id)/* ->cache(60) */->count(),
            'internal' => ShipModules::find()->internal($market_id)/* ->cache(60) */->count(),
            'utility' => ShipModules::find()->utility($market_id)/* ->cache(60) */->count(),
        ];
    }
}
