<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "markets".
 *
 * @property int $buy_price
 * @property int $demand
 * @property int $demand_bracket
 * @property int $mean_price
 * @property string $name
 * @property int $sell_price
 * @property int $stock
 * @property int $stock_bracket
 * @property int $market_id
 *
 * @property Stations $market
 */
class Markets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'markets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['buy_price', 'demand', 'demand_bracket', 'mean_price', 'name', 'sell_price', 'stock', 'stock_bracket', 'market_id', 'timestamp'], 'required'],
            [['buy_price', 'demand', 'demand_bracket', 'mean_price', 'sell_price', 'stock', 'stock_bracket', 'market_id'], 'integer'],
            [['name', 'timestamp'], 'string', 'max' => 50],
            [['name', 'market_id'], 'unique', 'targetAttribute' => ['name', 'market_id']],
            [['market_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['market_id' => 'market_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'buy_price' => 'Buy Price',
            'demand' => 'Demand',
            'demand_bracket' => 'Demand Bracket',
            'mean_price' => 'Mean Price',
            'name' => 'Name',
            'sell_price' => 'Sell Price',
            'stock' => 'Stock',
            'stock_bracket' => 'Stock Bracket',
            'market_id' => 'Market ID',
            'timestamp' => 'Timestamp',
            'distance' => 'dist'
        ];
    }

    /**
     * Gets query for [[Market]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['market_id' => 'market_id']);
    }
}
