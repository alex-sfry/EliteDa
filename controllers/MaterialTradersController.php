<?php

namespace app\controllers;

use app\models\MaterialTraders;
use app\models\MaterialTradersSearch;
use yii\data\Pagination;
use yii\web\Controller;

class MaterialTradersController extends Controller
{
    public function actionIndex(): string
    {
        $mt_traders = new MaterialTraders();
        $searchModel = new MaterialTradersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $pagination = new Pagination();
        $pagination->pageSize = 20;

        $dataProvider->setPagination($pagination);

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;

        return $this->render('index', $params);
    }
}
