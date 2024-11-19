<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\ar\Markets;
use app\traits\CommoditiesTrait;

class StationMarket extends Model
{
    use CommoditiesTrait;

    public function findMarket(int $id, string $sys_name): array
    {
        $model = Markets::find()
            ->where(['and', "markets.market_id=$id", ['or', 'stock>0', 'demand>0']])
            /* ->cache(3600) */
            ->asArray()
            ->all();

        foreach ($model as $key => $value) {
            $model[$key]['name'] = isset($this->commodities[strtolower($value['name'])]) ?
                $this->commodities[strtolower($value['name'])] : $model[$key]['name'];
            $model[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($model[$key]['timestamp']);
            unset($model[$key]['market_id']);

            $model[$key]['req_url'] = ArrayHelper::merge(
                ['commodities/index'],
                $this->getCommoditiesReqArr([
                    'commodity' => [$value['name']],
                    'system' => $sys_name,
                    'price_type' => $value['stock'] > $value['demand'] ? 'sell_price' : 'buy_price'
                ])
            );
        }

        return $model;
    }
}
