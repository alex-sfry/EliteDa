<?php

namespace app\models\forms;

class CommoditiesForm extends \yii\base\Model
{
    public string $refSystem = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $sortBy = '';
    public string $maxDistanceFromRefStar = '';
    public string $distanceFromStar = '';
    public string $minSupplyDemand = '';
    public string $dataAge = '';
    public string $buySellSwitch = '';
    public array $commodities_arr = [];

    public function rules(): array
    {
        return [
            [['refSystem'], 'required'],
            [['commodities_arr'], 'each', 'rule' => ['required', 'skipOnEmpty' => false]],
            [['buySellSwitch'], 'in', 'range' => ['buy', 'sell']],
            [['landingPadSize'], 'in', 'range' => ['L', 'M', 'S']],
            [['includeSurface'], 'in', 'range' => ['Yes', 'No']],
            [['sortBy'], 'in', 'range' => ['Updated_at', 'Distance', 'Price']],
            [['maxDistanceFromRefStar'], 'in', 'range' => ['Any', '25', '50', '100', '250']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['minSupplyDemand'], 'in', 'range' => ['Any', '100', '500', '1000', '2000', '5000', '10000']],
            [['dataAge'], 'in', 'range' => ['Any', '1', '4', '10', '24']],
        ];
    }
}
