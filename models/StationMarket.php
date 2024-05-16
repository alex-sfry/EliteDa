<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class StationMarket extends Model
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                CommoditiesBehavior::class,
                StationBehavior::class,
            ]
        );
    }

    /**
     * @return array
     */
    public function getMarket(int $id): array
    {
        $model = Markets::find()
            ->where(['and', "markets.market_id=$id", ['or', 'stock>0', 'demand>0']])
            ->asArray()
            ->all();

        foreach ($model as $key => $value) {
            $model[$key]['name'] = isset($this->commodities[strtolower($value['name'])]) ?
                $this->commodities[strtolower($value['name'])] : $model[$key]['name'];
            $model[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($model[$key]['timestamp']);
            unset($model[$key]['market_id']);
        }

        return $model;
    }
}
