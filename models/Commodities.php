<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commodities".
 *
 * @property int $id
 * @property string $symbol
 * @property string $category
 * @property string $name
 */
class Commodities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commodities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'symbol', 'category', 'name'], 'required'],
            [['id'], 'integer'],
            [['symbol', 'category', 'name'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'category' => 'Category',
            'name' => 'Name',
        ];
    }
}
