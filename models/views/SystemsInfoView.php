<?php

namespace app\models\views;

/**
 * This is the model class for sql view "systems_info_view".
 *
 * @property int $id
 * @property int|null $population
 * @property string|null $security
 * @property string|null $allegiance
 * @property string|null $economy
 * @property string|null $system
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 */
class SystemsInfoView extends \yii\db\ActiveRecord
{
    public $distance;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_systems_info';
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
            [['id', 'population'], 'integer'],
            [['system'], 'string', 'max' => 255],
            [['economy', 'allegiance', 'security'], 'string', 'max' => 50],
            [['x', 'y', 'z'], 'number'],
            [['distance'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system' => 'System',
            'population' => 'Population',
            'allegiance' => 'Allegiance',
            'economy' => 'Economy',
            'security' => 'Security',
            'x' => 'X',
            'y' => 'Y',
            'z' => 'Z',
            'distance' => 'Distance (LY)'
        ];
    }
}
