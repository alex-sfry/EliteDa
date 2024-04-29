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
            [['refSystem', 'cMainSelect'], 'required'],
            [[
                'landingPadSize',
                'includeSurface',
                'sortBy',
                'maxDistanceFromRefStar',
                'distanceFromStar',
                'dataAge'
            ], 'safe']
        ];
    }
}
