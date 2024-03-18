<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "economies".
 *
 * @property int $id
 * @property string|null $economy_id
 * @property string|null $economy_name
 *
 * @property Stations[] $stations
 * @property Stations[] $stations0
 * @property Systems[] $systems
 */
class Economies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'economies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['economy_id', 'economy_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'economy_id' => 'Economy ID',
            'economy_name' => 'Economy Name',
        ];
    }

    /**
     * Gets query for [[Stations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Stations::class, ['economy_id_1' => 'id']);
    }

    /**
     * Gets query for [[Stations0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStations0()
    {
        return $this->hasMany(Stations::class, ['economy_id_2' => 'id']);
    }

    /**
     * Gets query for [[Systems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(Systems::class, ['economy_id' => 'id']);
    }
}
