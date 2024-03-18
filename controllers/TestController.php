<?php

namespace app\controllers;

use yii\base\Controller;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

class TestController extends Controller
{
    public function actionIndex(): string
    {
//        $coriolis = 'Coriolis starport';
//        $ocellus = 'Ocellus starport';
//        $orbis = 'Orbis starport';
//
//        $distance = 50;
//
//        $n = ['1', '2', '3'];
//
//        $query1 = (new Query())
//            ->select([
//                new Expression(
//                    'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2) as distance'
//                ), 'stations.name as station_name', 'stations.type as type', 'systems.population'
//            ])
//            ->from('stations')
//            ->join('INNER JOIN', 'systems', 'stations.system_id = systems.id')
//            ->where("type=:123{$n[0]}")->addParams([":123{$n[0]}" => $coriolis])
//            ->andWhere([
//                '<', 'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2)', $distance
//            ])
//            ->orderBy('distance')
//            /*->limit(100)*/;
//
//        $query2 = (new Query())
//            ->select([
//                new Expression(
//                    'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2) as distance'
//                ), 'stations.name as station_name', 'stations.type as type', 'systems.population'
//            ])
//            ->from('stations')
//            ->join('INNER JOIN', 'systems', 'stations.system_id = systems.id')
//            ->where("type=:123{$n[1]}")->addParams([":123{$n[1]}" => $ocellus])
//            ->andWhere([
//                '<', 'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2)', $distance
//            ])
//            ->orderBy('distance')
//            /*->limit(100)*/;
//
//        $query3 = (new Query())
//            ->select([
//                new Expression(
//                    'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2) as distance'
//                ), 'stations.name as station_name', 'stations.type as type', 'systems.population'
//            ])
//            ->from('stations')
//            ->join('INNER JOIN', 'systems', 'stations.system_id = systems.id')
//            ->where(['type' => $orbis])
//            ->andWhere([
//                '<', 'ROUND(SQRT(POW((systems.x-0), 2)+POW((systems.y-0), 2)+POW((systems.z-0), 2)), 2)', $distance
//            ])
//            ->orderBy('distance')
//            /*->limit(100)*/;
//
//        $arr = [$query2, $query3];
//
//        foreach ($arr as $item) {
//            $query1->union($item);
//        }
//
//        $rawSQL = $query1->createCommand()->sql;
//
//        $result = (new Query())
//            ->select('*')
//            ->from($query1)
//            ->orderBy('distance');
////            ->limit(100);
//
//        $provider = new ActiveDataProvider([
//            'query' => $result,
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//
//        // get the posts in the current page
//        $stations = $provider->getModels();
//        $pager = $provider->getPagination();

        return $this->render('index', /*[
//            'count' =>  $stations->count(),
            'stations' => $stations,
            'pager' => $pager
//            'rawSQL' => $rawSQL
        ]*/);
    }
}
