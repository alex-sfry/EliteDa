<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ships_price_list".
 *
 * @property string $name
 * @property int|null $price
 */
class ShipsPriceList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ships_price_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'price' => 'Price',
        ];
    }
}
