<?php

namespace app\models\views;

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
            [['distance_to_arrival'], 'integer'],
            [['station', 'system'], 'string', 'max' => 255],
            [['type', 'government'], 'string', 'max' => 100],
            [['economy_name', 'allegiance'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'station' => 'Station',
            'system' => 'System',
            'type' => 'Type',
            'distance_to_arrival' => 'Dist. from star (ls)',
            'government' => 'Government',
            'allegiance' => 'Allegiance',
            'economy_name' => 'Economy (main)'
        ];
    }
}
