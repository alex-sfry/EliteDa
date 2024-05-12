<?php

namespace app\controllers;

use app\models\search\MaterialTradersSearch;
use app\models\Systems;
use Yii;
use yii\web\Controller;

class MaterialTradersController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
//        $session->destroy();
        $request = Yii::$app->request;

        if (count($request->post()) > 0) {
            $session->set('mt', $request->post());
        } else {
            !isset($session->get('mt')['refSysStation']) && $session->set('mt', ['refSysStation' => 'Sol']);
        }

        if (isset($session->get('mt')['refSysStation'])) {
            if ($session->get('mt')['refSysStation'] !== '') {
                $refCoords = Systems::find()
                    -> select(['x', 'y', 'z'])
                    ->where(['name' => $session->get('mt')['refSysStation']])
                    ->asArray()
                    ->one();
            }
        }

        if (!isset($refCoords)) {
            $refCoords = ['x' => 0, 'y' => 0, 'z' => 0];
        }

        $searchModel = new MaterialTradersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $refCoords);
        $dataProvider->pagination = ['pageSize' => 50];

        $dataProvider->sort->attributes['system.name'] = [
            'asc' => ['systems.name' => SORT_ASC],
            'desc' => ['systems.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['station.name'] = [
            'asc' => ['stations.name' => SORT_ASC],
            'desc' => ['stations.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;
        $params['refCoords'] = $refCoords;

        return $this->render('index', $params);
    }
}
