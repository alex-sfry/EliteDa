<?php

namespace app\models\ar;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "stations".
 *
 * @property int $id
 * @property int|null $market_id
 * @property int|null $system_id
 * @property string|null $name
 * @property string|null $type
 * @property int|null $distance_to_arrival
 * @property string|null $government
 * @property int|null $allegiance_id
 * @property int|null $economy_id_1
 * @property int|null $economy_id_2
 *
 * @property Allegiance $allegiance
 * @property Economies $economyId1
 * @property Economies $economyId2
 * @property Markets[] $markets
 * @property MaterialTraders[] $materialTraders
 * @property Systems $system
 */
class Stations extends \yii\db\ActiveRecord
{
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'sys_name', // for StationSearch
            'distance' // for StationSearch
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'required'],
            [['id', 'market_id', 'system_id', 'distance_to_arrival', 'allegiance_id', 'economy_id_1', 'economy_id_2'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type', 'government'], 'string', 'max' => 100],
            [['market_id'], 'unique'],
            [['id'], 'unique'],
            [['allegiance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Allegiance::class, 'targetAttribute' => ['allegiance_id' => 'id']],
            [['economy_id_1'], 'exist', 'skipOnError' => true, 'targetClass' => Economies::class, 'targetAttribute' => ['economy_id_1' => 'id']],
            [['economy_id_2'], 'exist', 'skipOnError' => true, 'targetClass' => Economies::class, 'targetAttribute' => ['economy_id_2' => 'id']],
            [['system_id'], 'exist', 'skipOnError' => true, 'targetClass' => Systems::class, 'targetAttribute' => ['system_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'market_id' => 'Market ID',
            'system_id' => 'System ID',
            'name' => 'Name',
            'type' => 'Type',
            'distance_to_arrival' => 'Distance To Arrival',
            'government' => 'Government',
            'allegiance_id' => 'Allegiance ID',
            'economy_id_1' => 'Economy Id 1',
            'economy_id_2' => 'Economy Id 2',
        ];
    }

    /**
     * Gets query for [[Allegiance]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllegiance(): ActiveQuery
    {
        return $this->hasOne(Allegiance::class, ['id' => 'allegiance_id']);
    }

    /**
     * Gets query for [[EconomyId1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEconomyId1(): ActiveQuery
    {
        return $this->hasOne(Economies::class, ['id' => 'economy_id_1']);
    }

    /**
     * Gets query for [[EconomyId2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEconomyId2(): ActiveQuery
    {
        return $this->hasOne(Economies::class, ['id' => 'economy_id_2']);
    }

    /**
     * Gets query for [[Markets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkets(): ActiveQuery
    {
        return $this->hasMany(Markets::class, ['market_id' => 'market_id']);
    }

     /**
     * Gets query for [[Markets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShipModules(): ActiveQuery
    {
        return $this->hasMany(ShipModules::class, ['market_id' => 'market_id']);
    }

    /**
     * Gets query for [[MaterialTraders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialTraders(): ActiveQuery
    {
        return $this->hasMany(MaterialTraders::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[System]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystem(): ActiveQuery
    {
        return $this->hasOne(Systems::class, ['id' => 'system_id']);
    }
}
