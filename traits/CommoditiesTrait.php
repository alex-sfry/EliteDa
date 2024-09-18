<?php

namespace app\traits;

use yii\helpers\Json;

trait CommoditiesTrait
{
    private array $commoditiesReqArr = [
        'cMainSelect' => [],
        'refSystem' => 'Sol',
        'landingPadSize' => 'S',
        'includeSurface' => 'Yes',
        'sortBy' => 'Price',
        'distanceFromStar' => '500',
        'minSupplyDemand' => '1000',
        'dataAge' => 'Any',
        'buySellSwitch' => 'buy_price',
        'formBtn' => ''
    ];

    public function getCommodities(): array
    {
        $arr = Json::decode(file_get_contents(\Yii::$app->basePath . '/data/commodities.json'));
        asort($arr);

        return $arr;
    }

    public function getCommoditiesReqArr(array $params): array
    {
        $this->commoditiesReqArr['buySellSwitch'] = $params['price_type'];
        $this->commoditiesReqArr['refSystem'] = $params['system'];
        $this->commoditiesReqArr['cMainSelect'] = $params['commodity'];

        return $this->commoditiesReqArr;
    }
}
