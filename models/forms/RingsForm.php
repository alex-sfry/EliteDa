<?php

namespace app\models\forms;

class RingsForm extends \yii\base\Model
{
    public string $type = '';
    public string $maxDistanceFromRefStar = '';
    public string $distanceFromStar = '';
    public string $sortBy = '';
    public string $refSystem = '';

    public function rules(): array
    {
        return [
            [['refSystem'], 'required'],
            [['sortBy'], 'in', 'range' => ['DistanceLy', 'DistanceLs']],
            [['maxDistanceFromRefStar'], 'in', 'range' => ['25', '50', '100', '150']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['type'], 'in', 'range' => ['Icy', 'Metal Rich', 'Metallic', 'Rocky']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Type:',
            'maxDistanceFromRefStar' => 'Max distance from ref. system:',
            'distanceFromStar' => 'Max. distance from the star:',
            'sortBy' => 'Sort by:',
            'refSystem' => 'Ref. system:',
        ];
    }
}
