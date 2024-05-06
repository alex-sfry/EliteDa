<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Json;

class CommoditiesBehavior extends Behavior
{
    /**
     * @return array
     */
    public function getCommodities(): array
    {
        $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/commodities.json'));
        asort($arr);

        return $arr;
    }
}
