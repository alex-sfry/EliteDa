<?php

namespace app\behaviors;

use yii\base\Behavior;
use Yii;
use yii\helpers\Json;

class ShipModulesBehavior extends Behavior
{
    /**
     * @return array
     */
    public function getShipModules(): array
    {
        return array_change_key_case(Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json')));
    }
}
