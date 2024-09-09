<?php

namespace app\models\forms;

class SystemsForm extends \yii\base\Model
{
    public $maxDistanceFromRefStar = 50;
    public string $refSystem = 'Sol';

    public function rules(): array
    {
        return [
            [['refSystem'], 'string'],
            ['refSystem', 'default', 'value' => 'Sol'],
            ['maxDistanceFromRefStar', 'default', 'value' => 50],
            ['maxDistanceFromRefStar', 'filter', 'filter' => 'intval'],
            ['maxDistanceFromRefStar', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'maxDistanceFromRefStar' => 'Max distance from ref. system:',
            'refSystem' => 'Ref. system:',
        ];
    }
}
