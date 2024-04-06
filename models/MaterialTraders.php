<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "material_traders".
 *
 * @property string|null $material_type
 * @property int $id
 * @property int $system_id
 * @property int $station_id
 *
 * @property Stations $station
 * @property Systems $system
 */
class MaterialTraders extends ActiveRecord
{
    public $distance;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'material_traders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['system_id', 'station_id'], 'required'],
            [['system_id', 'station_id'], 'integer'],
            [['material_type'], 'string', 'max' => 50],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
            [['system_id'], 'exist', 'skipOnError' => true, 'targetClass' => Systems::class, 'targetAttribute' => ['system_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'material_type' => 'Material Type',
            'id' => 'ID',
            'distance' => 'Distance',
            'system_id' => 'System ID',
            'station_id' => 'Station ID',
        ];
    }

    /**
     * Gets query for [[Station]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
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
