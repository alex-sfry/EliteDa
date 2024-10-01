<?php

namespace app\models\forms;

class StationsAdvancedForm extends \yii\base\Model
{
    public string $refSystem = '';
    public string $population = '';
    public string $pad = 'L';
    public string $inclSurface = 'No';
    public string $dta = '';
    public string $government = '';
    public string $allegiance = '';
    public string $economy = '';

    public function rules(): array
    {
        return [
            ['refSystem', 'required'],
            [['refSystem'], 'string', 'length' => [2]],
            [['population'], 'in', 'range' => [
                'Any',
                '10000000',
                '100000000',
                '1000000000',
                '10000000000',
                '20000000000'
            ]],
            [['pad'], 'in', 'range' => ['L', 'M', 'S']],
            [['inclSurface'], 'in', 'range' => ['No', 'Yes', 'Odyssey']],
            [['dta'], 'in', 'range' => ['Any', '500', '1000', '2000', '5000']],
            [['government'], 'in', 'range' => [
                'Any' => 'Any',
                'Anarchy' => 'Anarchy',
                'Communism' => 'Communism',
                'Confederacy' => 'Confederacy',
                'Cooperative' => 'Cooperative',
                'Corporate' => 'Corporate',
                'Democracy' => 'Democracy',
                'Dictatorship' => 'Dictatorship',
                'Feudal' => 'Feudal',
                'Patronage' => 'Patronage',
                'Prison colony' => 'Prison colony',
                'Theocracy' => 'Theocracy',
                'Workshop (Engineer)' => 'Workshop (Engineer)',
                'Engineer' => 'Engineer',
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
            [['population', 'dta', 'allegiance', 'economy', 'government'], 'filter', 'filter' => function ($value) {
                return $value === 'Any' ? '' : $value;
            }],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'refSystem' => 'Ref. system',
            'population' => 'System population',
            'pad' => 'Min pad size',
            'inclSurface' => 'Include surface',
            'dta' => 'Dist. to arrival',
            'allegiance' => 'Allegiance',
            'economy' => 'Economy',
            'government' => 'Government',
        ];
    }
}
