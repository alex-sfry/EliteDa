<?php

namespace app\models;

class CommoditiesForm extends \yii\base\Model
{
    public string $refStation = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $sortBy = '';
    public string $maxDistanceFromRefStar = '';
    public string $distanceFromStar = '';
    public string $minSupplyDemand = '';
    public string $dataAge = '';
    public string $buySellSwitch = 'buy';
    public array $commodities = [];

    public function rules(): array
    {
        return [
            [['refStation', 'commodities'], 'required'],
            [[
                'landingPadSize',
                'includeSurface',
                'sortBy',
                'maxDistanceFromRefStar',
                'distanceFromStar',
                'minSupplyDemand',
                'dataAge',
                'buySellSwitch'
            ], 'safe']
        ];
    }
}
