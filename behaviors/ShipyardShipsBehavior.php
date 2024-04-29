<?php

namespace app\behaviors;

use yii\base\Behavior;
use Yii;
use yii\helpers\Json;

class ShipyardShipsBehavior extends Behavior
{
    /**
     * @return array
     */
    public function getShipsList(): array
    {
        return Json::decode(file_get_contents(Yii::$app->basePath . '/data/ships.json'));
    }
}
