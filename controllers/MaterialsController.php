<?php

namespace app\controllers;

use app\models\search\MaterialsSearch;
use yii\web\Controller;

/**
 * MaterialsController implements the CRUD actions for Materials model.
 */
class MaterialsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new MaterialsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 50];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
