<?php

namespace app\models\forms;

class ShipyardShipsForm extends \yii\base\Model
{
    public string $refSystem = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $sortBy = '';
    public string $maxDistanceFromRefStar = '';
    public string $distanceFromStar = '';
    public string $dataAge = '';
    public array $cMainSelect = [];

    public function rules(): array
    {
        return [
            [['refSystem'], 'required'],
            [['cMainSelect'], 'each', 'rule' => ['required', 'skipOnEmpty' => false]],
            [['landingPadSize'], 'in', 'range' => ['L', 'M', 'S']],
            [['includeSurface'], 'in', 'range' => ['Yes', 'No']],
            [['sortBy'], 'in', 'range' => ['Updated_at', 'Distance', 'Module']],
            [['maxDistanceFromRefStar'], 'in', 'range' => ['Any', '25', '50', '100', '250']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['dataAge'], 'in', 'range' => ['Any', '1', '4', '10', '24']],
        ];
    }
}
