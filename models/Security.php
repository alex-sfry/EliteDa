<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "security".
 *
 * @property int $id
 * @property string|null $security_id
 * @property string|null $security_level
 *
 * @property Systems[] $systems
 */
class Security extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'security';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['security_id', 'security_level'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'security_id' => 'Security ID',
            'security_level' => 'Security Level',
        ];
    }

    /**
     * Gets query for [[Systems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(Systems::class, ['security_id' => 'id']);
    }
}
