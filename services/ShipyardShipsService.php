<?php

namespace app\services;

use app\models\ar\ShipsPriceList;
use app\models\ar\Shipyard;
use app\traits\ShipyardShipsTrait;
use app\traits\StationConditionsTrait;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Expression;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;

class ShipyardShipsService
{
    use ShipyardShipsTrait;
    use StationConditionsTrait;

    public ?array $form = null;
    public ?array $ships_list = null;

    public function __construct(array $form = null)
    {
        $this->form = $form;
        $this->ships_list = $this->getShipsList();
    }

    /**
     * @throws InvalidConfigException
     */
    public function findShips(): ActiveQuery
    {
        if (!is_array($this->form)) {
            throw new InvalidConfigException();
        }

        $sys_service = new SystemsService();
        $distance_expr = $sys_service->distanceExpr($this->form['refSystem']);

        $price = ShipsPriceList::find()
            ->select('price')
            ->where(['name' => "{$this->ships_list[$this->form['cMainSelect']]}"])
            ->cache(86400)
            ->one();

        return Shipyard::find()
            ->select([
                'shipyard.*',
                new Expression("{$price->price} as price"),
                "IF(type!='Outpost','L','M') as pad",
                "IF(type IN ('Planetary Outpost', 'Planetary Port', 'Odyssey Settlement'),TRUE,FALSE) as surface",
                "$distance_expr as distance",
                "timestamp"
            ])
            ->ships($this->form['cMainSelect'])
            ->filter([
                'distanceFromStar' => $this->form['distanceFromStar'],
                'surface' => $this->surfaceCondition($this->form['includeSurface'])
            ]);
    }

    public function findStationShips(int $market_id, string $sys_name): array
    {
        $ships = Shipyard::find()
            ->stationShips($market_id)
            ->cache(600)
            ->asArray()
            ->all();

        foreach ($ships as $key => $value) {
            $ships[$key]['price'] = \Yii::$app->formatter->asInteger((int)$value['price']);
            $ships[$key]['timestamp'] = \Yii::$app->formatter->asRelativeTime($value['timestamp']);
            $ships[$key]['req_url'] = ArrayHelper::merge(
                ['shipyard-ships/index'],
                $this->getShipsReqArr([
                    'ship' => $ships[$key]['symbol'],
                    'system' => $sys_name,
                ])
            );
        }

        return $ships;
    }
}
