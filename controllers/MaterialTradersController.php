<?php

namespace app\controllers;

use app\models\MaterialTradersSearch;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class MaterialTradersController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
//        $session->destroy();
        $request = Yii::$app->request;
        !$session->get('mt') && $session->set('mt', $request->post());

        $searchModel = new MaterialTradersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->attributes['system.name'] = [
            'asc' => ['systems.name' => SORT_ASC],
            'desc' => ['systems.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['station.name'] = [
            'asc' => ['stations.name' => SORT_ASC],
            'desc' => ['stations.name' => SORT_DESC],
        ];
        $pagination = new Pagination();
        $pagination->pageSize = 20;

        $dataProvider->setPagination($pagination);

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;
        $params['request'] = $session->get('mt');

        return $this->render('index', $params);
    }
}
