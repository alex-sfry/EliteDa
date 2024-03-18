<?php

namespace app\models;

use yii\base\Model;

class TradeRoutes extends Model
{
    public function getData(): array
    {
        $markets = new Markets();
        $stations = new Stations();
        $systems = new Systems();

        return [];
    }
}
