<?php

namespace app\models\ar;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "commodities".
 *
 * @property int $id
 * @property string $symbol
 * @property string $category
 * @property string $name
 */
class Commodities extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commodities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'symbol', 'category', 'name'], 'required'],
            [['id'], 'integer'],
            [['symbol', 'category', 'name'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'category' => 'Category',
            'name' => 'Name',
        ];
    }
}
