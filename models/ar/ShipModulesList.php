<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "ship_modules".
 *
 * @property int $id
 * @property string $symbol
 * @property string $name
 * @property string|null $mount
 * @property string|null $category
 * @property string|null $guidance
 * @property string|null $ship
 * @property int $class
 * @property string $rating
 * @property string|null $entitlement
 */
class ShipModulesList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ship_modules_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'symbol', 'name', 'class', 'rating'], 'required'],
            [['id', 'class'], 'integer'],
            [['entitlement'], 'string'],
            [['symbol', 'name'], 'string', 'max' => 255],
            [['mount', 'category', 'guidance'], 'string', 'max' => 50],
            [['ship'], 'string', 'max' => 100],
            [['rating'], 'string', 'max' => 8],
            [['symbol'], 'unique'],
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
            'name' => 'Name',
            'mount' => 'Mount',
            'category' => 'Category',
            'guidance' => 'Guidance',
            'ship' => 'Ship',
            'class' => 'Class',
            'rating' => 'Rating',
            'entitlement' => 'Entitlement',
        ];
    }
}
