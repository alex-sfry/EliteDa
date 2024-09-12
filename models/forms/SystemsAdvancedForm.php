<?php

namespace app\models\forms;

use app\behaviors\ControllerEventBehavior;

use function app\helpers\d;

class SystemsAdvancedForm extends \yii\base\Model
{
    public string $refSystem = '';
    public string $population = '';
    public string $allegiance = '';
    public string $economy = '';
    public string $security = '';

    public function rules(): array
    {
        return [
            ['refSystem', 'required'],
            ['refSystem', 'string', 'length' => [2]],
            [['population'], 'in', 'range' => [
                'Any',
                '10000000',
                '100000000',
                '1000000000',
                '10000000000',
                '20000000000'
            ]],
            [['allegiance'], 'in', 'range' => [
                'Any',
                'Alliance',
                'Empire',
                'Federation',
                'Independent',
                'None',
                'Pirate'
            ]],
            [['economy'], 'in', 'range' => [
                'Any',
                'Agriculture',
                'Colony',
                'Damaged',
                'Extraction',
                'High Tech',
                'Industrial',
                'Military',
                'None',
                'Prison',
                'Private Enterprise',
                'Refinery',
                'Repair',
                'Rescue',
                'Service',
                'Terraforming',
                'Tourism',
                'Engineering',
            ]],
            [['security'], 'in', 'range' => ['Any', 'Anarchy', 'Lawless', 'Low', 'Medium', 'High']],
            [['population', 'allegiance', 'economy', 'security'], 'filter', 'filter' => function ($value) {
                return $value === 'Any' ? '' : $value;
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'refSystem' => 'Ref. system',
            'population' => 'Population',
            'allegiance' => 'Allegiance',
            'economy' => 'Economy',
            'security' => 'Security',
        ];
    }
}
