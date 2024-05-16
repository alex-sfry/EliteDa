<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class StationBehavior extends Behavior
{
    private array $landingPadSizes = [
        'Coriolis Starport' => 'L',
        'Ocellus Starport' => 'L',
        'Orbis Starport' => 'L',
        'Asteroid base' => 'L',
        'Outpost' => 'M',
        'Planetary Outpost' => 'L',
        'Planetary Port' => 'L',
        'Mega ship' => 'L',
        'Fleet Carrier' => 'L',
        'Odyssey Settlement' => 'S or L',
    ];

    private array $commoditiesReqArr = [
        'commodities' => [],
        'refSystem' => 'Sol',
        'landingPadSize' => 'S',
        'includeSurface' => 'Yes',
        'sortBy' => 'Price',
        'maxDistanceFromRefStar' => '50',
        'distanceFromStar' => '500',
        'minSupplyDemand' => '1000',
        'dataAge' => 'Any',
        'buySellSwitch' => 'buy',
        'c-form-submit' => ''
    ];

    /**
     * @return array
     */
    public function getLandingPadSizes(): array
    {
        return $this->landingPadSizes;
    }

    /**
     * @var array $commodities
     * @return array
     */
    public function getCommoditiesReqArr(array $commodities): array
    {
        $this->commoditiesReqArr['commodities'] = $commodities;

        return $this->commoditiesReqArr;
    }
}
