<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ship_modules".
 *
 * @property int $market_id
 * @property string $name
 * @property string $timestamp
 *
 * @property Stations $market
 */
class ShipModules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ship_modules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['market_id', 'name', 'timestamp'], 'required'],
            [['market_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['timestamp'], 'string', 'max' => 50],
            [['market_id', 'name'], 'unique', 'targetAttribute' => ['market_id', 'name']],
            [
                ['market_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => Stations::class,
                'targetAttribute' => ['market_id' => 'market_id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'market_id' => 'Market ID',
            'name' => 'Name',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[Market]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['market_id' => 'market_id'])->inverseOf('shipModules');
    }
}
