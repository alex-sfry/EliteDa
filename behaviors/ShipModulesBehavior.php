<?php

namespace app\behaviors;

use yii\base\Behavior;
use Yii;
use yii\helpers\Json;

class ShipModulesBehavior extends Behavior
{
    protected array $shipModulesReqArr = [
        'cMainSelect' => [],
        'refSystem' => 'Sol',
        'landingPadSize' => 'L',
        'includeSurface' => 'No',
        'maxDistanceFromRefStar' => '50',
        'distanceFromStar' => '500',
        'dataAge' => 'Any',
        'sortBy' => 'Distance',
        'c-form-submit' => ''
    ];

    public function getShipModules(): array
    {
        return array_change_key_case(Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json')));
    }

    public function getShipModulesReqArr(array $params): array
    {
        $this->shipModulesReqArr['refSystem'] = $params['system'];
        $this->shipModulesReqArr['cMainSelect'] = $params['module'];

        return $this->shipModulesReqArr;
    }
}
