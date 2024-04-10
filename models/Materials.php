<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "materials".
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $grade
 * @property string $type
 * @property string|null $location
 */
class Materials extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'materials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'category', 'grade', 'type'], 'required'],
            [['location'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['category', 'type'], 'string', 'max' => 100],
            [['grade'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'category' => 'Category',
            'grade' => 'Grade',
            'type' => 'Type',
            'location' => 'Location',
        ];
    }
}
