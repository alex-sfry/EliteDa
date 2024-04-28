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
    public function getShipModules($lower_case = 'all'): array
    {
        // if ($lower_case === 'first') {
        //     $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json'));

        //     foreach ($arr as $key => $value) {
        //         $key = lcfirst($key);
        //     }

        //     return $arr;
        // } else {
        //     return array_change_key_case(Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json')));
        // }
        return array_change_key_case(Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json')));
        // return Json::decode(file_get_contents(Yii::$app->basePath . '/data/shipModules.json'));
    }
}
