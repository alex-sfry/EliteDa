<?php

namespace app\services;

use app\models\ar\Markets;
use app\traits\CommoditiesTrait;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Expression;

use function app\helpers\d;

class CommoditiesService
{
    use CommoditiesTrait;

    public ?array $form = null;
    public ?array $commodity_list = null;
    public ?string $price_type = null;
    public ?string $stock_demand = null;
    public ?string $order = null;

    public function __construct(array $form = null)
    {
        $this->form = $form;
        $this->commodity_list = $this->getCommodities();
    }

    /**
     * @throws InvalidConfigException
     */
    public function findCommodPrices(): ActiveQuery
    {
        if (!is_array($this->form)) {
            throw new InvalidConfigException();
        }

        $column_map = ['buy_price' => 'stock', 'sell_price' => 'demand'];
        $sort_map = ['UpdatedAt' => 'timestamp DESC','Distance' => 'distance'];

        $this->price_type = $this->form['buySellSwitch'];
        $this->stock_demand = $column_map[$this->form['buySellSwitch']];

        if ($this->price_type === 'sell_price') {
            $sort_map['Price'] = "{$this->price_type} DESC";
        } else {
            $sort_map['Price'] = "{$this->price_type}";
        }

        $sys_service = new SystemsService();
        $distance_expr = $sys_service->distanceExpr($this->form['refSystem']);
        $date_sub_expr = empty($this->form['dataAge']) ?
            '' : new Expression("DATE_SUB(NOW(), INTERVAL {$this->form['dataAge']} HOUR)");
        $this->order = isset($sort_map[$this->form['sortBy']]) ? $sort_map[$this->form['sortBy']] : 'distance';

        return Markets::find()
            ->select([
                'markets.*',
                "IF(type!='Outpost','L','M') as pad",
                "IF(type IN ('Planetary Outpost', 'Planetary Port', 'Odyssey Settlement'),TRUE,FALSE) as surface",
                "$distance_expr as distance"
            ])
            ->prices($this->form, $this->stock_demand, $date_sub_expr)
            ->andWhere(['<=', $distance_expr, 150])
            ->orderBy($this->order);
    }
}
