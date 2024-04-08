<?php

namespace app\models\forms;

use yii\base\Model;

class TradeRoutesForm extends Model
{
    public string $refSysStation = '';
    public string $targetSysStationName = '';
    public string $cargo = '';
    public string $profit = '';
    public string $landingPadSize = '';
    public string $includeSurface = '';
    public string $sortBy = '';
    public string $maxDistanceFromRefStar = '';
    public string $distanceFromStar = '';
    public string $minSupplyDemand = '';
    public string $dataAge = '';
    public string $targetSysStation = '';
    public bool $roundTrip = false;

    public function rules(): array
    {
        return [
            [['refSysStation', 'cargo', 'profit'], 'required'],
            [[
                'landingPadSize',
                'includeSurface',
                'sortBy',
                'targetSysStationName',
                'maxDistanceFromRefStar',
                'distanceFromStar',
                'minSupplyDemand',
                'dataAge',
                'targetSysStation',
                'roundTrip'
            ], 'safe']
        ];
    }
}
