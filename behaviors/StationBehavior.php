<?php

namespace app\behaviors;

use yii\base\Behavior;

class StationBehavior extends Behavior
{
    private array $landingPadSizes = [
        'Ocellus Starport' => 'L',
        'Orbis Starport' => 'L',
        'Outpost' => 'M',
        'Coriolis Starport' => 'L',
        'Planetary Outpost' => 'L',
        'Asteroid base' => 'L',
        'Planetary Port' => 'L',
        'Mega ship' => 'L',
        'Fleet Carrier' => 'L',
        'Odyssey Settlement' => 'S or L',
    ];

    public function getLandingPadSizes(): array
    {
        return $this->landingPadSizes;
    }
}
