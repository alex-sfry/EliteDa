<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;

use function app\helpers\d;

class MaterialsController extends Controller
{
    public function __construct($id, $module, private \app\models\search\MaterialsSearch $searchModel, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $dataProvider = $this->searchModel->search($this->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 50];

        if (empty($this->request->queryParams) || !isset($this->request->queryParams['MaterialsSearch'])) {
            $params['queryParams']['MaterialsSearch'] = array_fill_keys(
                array_values($this->searchModel->activeAttributes()),
                null
            );
        } else {
            $params['queryParams'] = ArrayHelper::htmlEncode($this->request->queryParams);
        }

        $params['searchModel'] = $this->searchModel;
        $params['dataProvider'] = $dataProvider;

        return $this->render('index', $params);
    }
}
