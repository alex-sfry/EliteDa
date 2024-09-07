<?php

namespace app\models\ar;

use app\models\aq\RingsQuery;
use Yii;

/**
 * This is the model class for table "rings".
 *
 * @property string $name
 * @property string|null $type
 * @property string|null $system_name
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 * @property int|null $distance_to_arrival
 * @property string|null $body_name
 * @property string|null $reserve
 * @property string|null $timestamp
 */
class Rings extends \yii\db\ActiveRecord
{
    public ?float $distance = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['x', 'y', 'z'], 'number'],
            [['distance_to_arrival'], 'integer'],
            [['name', 'system_name', 'body_name'], 'string', 'max' => 255],
            [['type', 'reserve', 'timestamp'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'system_name' => 'System Name',
            'x' => 'X',
            'y' => 'Y',
            'z' => 'Z',
            'distance_to_arrival' => 'Distance To Arrival',
            'body_name' => 'Body Name',
            'reserve' => 'Reserve',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RingsQuery(get_called_class());
    }
}
