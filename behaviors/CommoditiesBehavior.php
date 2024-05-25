<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Json;

class CommoditiesBehavior extends Behavior
{
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
    public function getCommodities(): array
    {
        $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/commodities.json'));
        asort($arr);

        return $arr;
    }

    /**
     * @var array $params
     *
     * @return array
     */
    public function getCommoditiesReqArr(array $params): array
    {
        $this->commoditiesReqArr['buySellSwitch'] = $params['price_type'];
        $this->commoditiesReqArr['refSystem'] = $params['system'];
        $this->commoditiesReqArr['commodities'] = $params['commodity'];

        return $this->commoditiesReqArr;
    }
}
