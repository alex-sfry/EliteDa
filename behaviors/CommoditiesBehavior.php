<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Json;

class CommoditiesBehavior extends Behavior
{
    protected array $commoditiesReqArr = [
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

    public function getCommodities(): array
    {
        $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/commodities.json'));
        asort($arr);

        return $arr;
    }

    public function getCommoditiesReqArr(array $params): array
    {
        $this->commoditiesReqArr['buySellSwitch'] = $params['price_type'];
        $this->commoditiesReqArr['refSystem'] = $params['system'];
        $this->commoditiesReqArr['commodities_arr'] = $params['commodity'];

        return $this->commoditiesReqArr;
    }
}
