<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ships_list".
 *
 * @property int $id
 * @property string $symbol
 * @property string $name
 * @property string|null $entitlement
 */
class ShipsList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ships_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'symbol', 'name'], 'required'],
            [['id'], 'integer'],
            [['entitlement'], 'string'],
            [['symbol', 'name'], 'string', 'max' => 255],
            [['symbol'], 'unique'],
            [['name'], 'unique'],
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
            'entitlement' => 'Entitlement',
        ];
    }
}
