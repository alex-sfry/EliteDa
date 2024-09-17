<?php

namespace app\traits;

use Yii;
use yii\helpers\Json;

trait ShipModulesTrait
{
    private array $shipModulesReqArr = [
        'cMainSelect' => [],
        'refSystem' => 'Sol',
        'landingPadSize' => 'L',
        'includeSurface' => 'No',
        'distanceFromStar' => 'Any',
        'formBtn' => ''
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
