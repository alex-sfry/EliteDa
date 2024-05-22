<?php

namespace app\models\ar;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "systems".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 * @property int|null $population
 * @property int|null $security_id
 * @property int|null $allegiance_id
 * @property int|null $economy_id
 *
 * @property Allegiance $allegiance
 * @property Economies $economy
 * @property MaterialTraders[] $materialTraders
 * @property Security $security
 * @property Stations[] $stations
 */
class Systems extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'systems';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'required'],
            [['id', 'population', 'security_id', 'allegiance_id', 'economy_id'], 'integer'],
            [['x', 'y', 'z'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['id'], 'unique'],
            [['allegiance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Allegiance::class, 'targetAttribute' => ['allegiance_id' => 'id']],
            [['economy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Economies::class, 'targetAttribute' => ['economy_id' => 'id']],
            [['security_id'], 'exist', 'skipOnError' => true, 'targetClass' => Security::class, 'targetAttribute' => ['security_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'x' => 'X',
            'y' => 'Y',
            'z' => 'Z',
            'population' => 'Population',
            'security_id' => 'Security ID',
            'allegiance_id' => 'Allegiance ID',
            'economy_id' => 'Economy ID'
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
     * Gets query for [[Economy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEconomy(): ActiveQuery
    {
        return $this->hasOne(Economies::class, ['id' => 'economy_id']);
    }

    /**
     * Gets query for [[MaterialTraders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialTraders(): ActiveQuery
    {
        return $this->hasMany(MaterialTraders::class, ['system_id' => 'id']);
    }

    /**
     * Gets query for [[Security]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecurity(): ActiveQuery
    {
        return $this->hasOne(Security::class, ['id' => 'security_id']);
    }

    /**
     * Gets query for [[Stations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStations(): ActiveQuery
    {
        return $this->hasMany(Stations::class, ['system_id' => 'id']);
    }
}
