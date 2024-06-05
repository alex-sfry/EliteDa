<?php

namespace app\models\views;

/**
 * This is the model class for sql view "stations_info_view".
 *
 * @property int $id
 * @property int|null $system_id
 * @property string|null $station
 * @property string|null $type
 * @property int|null $distance_to_arrival
 * @property string|null $government
 * @property string|null $allegiance
 * @property string|null $economy_name
 * @property int|null $population
 * @property string|null $system
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 */
class StationsInfoView extends \yii\db\ActiveRecord
{
    public $distance;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_stations_info';
    }

    // public static function primaryKey()
    // {
    //     return ['id'];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distance_to_arrival', 'id', 'system_id'], 'integer'],
            [['station', 'system'], 'string', 'max' => 255],
            [['type', 'government'], 'string', 'max' => 100],
            [['economy_name', 'allegiance'], 'string', 'max' => 50],
            [['x', 'y', 'z'], 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station' => 'Station',
            'system' => 'System',
            'type' => 'Type',
            'distance_to_arrival' => 'Dist. from star (ls)',
            'government' => 'Government',
            'allegiance' => 'Allegiance',
            'economy_name' => 'Economy (main)',
            'x' => 'X',
            'y' => 'Y',
            'z' => 'Z',
            'system_id' => 'System ID'
        ];
    }
}
