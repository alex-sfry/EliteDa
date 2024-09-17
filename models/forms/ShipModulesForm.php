<?php

namespace app\models\forms;

class ShipModulesForm extends \yii\base\Model
{
    public array $cMainSelect = [];
    public string $refSystem = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $distanceFromStar = '';

    public function rules(): array
    {
        return [
            [['refSystem'], 'required'],
            [['cMainSelect'], 'each', 'rule' => ['required', 'skipOnEmpty' => false]],
            [['landingPadSize'], 'in', 'range' => ['L', 'M', 'S']],
            [['includeSurface'], 'in', 'range' => ['No', 'Yes']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['distanceFromStar'], 'filter', 'filter' => function ($value) {
                return $value === 'Any' ? '' : $value;
            }],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'cMainSelect' => 'Module',
            'refSystem' => 'Ref. system',
            'landingPadSize' => 'Min. landing pad size',
            'includeSurface' => 'Include surface',
            'distanceFromStar' => 'Dist. to arrival',
        ];
    }
}
