<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "allegiance".
 *
 * @property int $id
 * @property string|null $faction_id
 * @property string|null $faction_name
 *
 * @property Stations[] $stations
 * @property Systems[] $systems
 */
class Allegiance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allegiance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faction_id', 'faction_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faction_id' => 'Faction ID',
            'faction_name' => 'Faction Name',
        ];
    }

    /**
     * Gets query for [[Stations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Stations::class, ['allegiance_id' => 'id']);
    }

    /**
     * Gets query for [[Systems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(Systems::class, ['allegiance_id' => 'id']);
    }
}
