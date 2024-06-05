<?php

namespace app\controllers;

use app\models\search\MaterialsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

use function app\helpers\d;

class MaterialsController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new MaterialsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 50];

        if (empty($this->request->queryParams) || !isset($this->request->queryParams['?MaterialsSearch'])) {
            $params['queryParams']['MaterialsSearch'] = array_fill_keys(
                array_values($searchModel->activeAttributes()),
                null
            );
        } else {
            $params['queryParams'] = ArrayHelper::htmlEncode($this->request->queryParams);
        }

        $params['searchModel'] = $searchModel;
        $params['dataProvider'] = $dataProvider;

        return $this->render('index', $params);
    }
}
