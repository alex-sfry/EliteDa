<?php

namespace app\models\ar;

use app\models\aq\ShipyardQuery;
use Yii;

/**
 * This is the model class for table "shipyard".
 *
 * @property int $market_id
 * @property string $name
 * @property string $timestamp
 *
 * @property Stations $market
 */
class Shipyard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipyard';
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
                'exist',
                'skipOnError' => true,
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
    public function getStation()
    {
        return $this->hasOne(Stations::class, ['market_id' => 'market_id'])/* ->inverseOf('shipyards') */;
    }

    /**
     * {@inheritdoc}
     * @return ShipyardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShipyardQuery(get_called_class());
    }
}
