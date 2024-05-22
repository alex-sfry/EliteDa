<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "modules_price_list".
 *
 * @property string $symbol
 * @property int|null $price
 */
class ModulesPriceList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modules_price_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol'], 'required'],
            [['price'], 'integer'],
            [['symbol'], 'string', 'max' => 255],
            [['symbol'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'symbol' => 'Symbol',
            'price' => 'Price',
        ];
    }
}
