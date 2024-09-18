<?php

namespace app\models\forms;

class CommoditiesForm extends \yii\base\Model
{
    public array $cMainSelect = [];
    public string $refSystem = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $sortBy = '';
    public string $distanceFromStar = '';
    public string $minSupplyDemand = '';
    public string $dataAge = '';
    public string $buySellSwitch = '';

    public function rules(): array
    {
        return [
            [['refSystem'], 'required'],
            [['cMainSelect'], 'each', 'rule' => ['required', 'skipOnEmpty' => false]],
            [['landingPadSize'], 'in', 'range' => ['L', 'M', 'S']],
            [['includeSurface'], 'in', 'range' => ['No', 'Yes', 'Odyssey']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['minSupplyDemand'], 'in', 'range' => ['Any', '100', '500', '1000', '2000', '5000', '10000']],
            [['dataAge'], 'in', 'range' => ['Any', '1', '4', '10', '24']],
            [['sortBy'], 'in', 'range' => ['Price', 'UpdatedAt', 'Distance']],
            [['buySellSwitch'], 'in', 'range' => ['buy_price', 'sell_price']],
            [['distanceFromStar', 'minSupplyDemand','dataAge'], 'filter', 'filter' => function ($value) {
                return $value === 'Any' ? '' : $value;
            }],
        ];
    }

    public function attributeLabels(): array
    {
        return [

            'refSystem' => 'Ref. system',
            'cMainSelect' => 'Commodities',
            'landingPadSize' => 'Min. landing pad size',
            'includeSurface' => 'Include surface',
            'distanceFromStar' => 'Dist. to arrival',
            'minSupplyDemand' => 'Min. supply / demand',
            'dataAge' => 'Updated',
            'sortBy' => 'Sort by',
        ];
    }
}
