<?php

namespace app\controllers;

use app\models\search\EngineersSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class EngineersController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new EngineersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;
        $params['queryParams'] = $this->request->queryParams;

        return $this->render('index', $params);
    }

    public function actionDetails(int $id): string
    {
        $engineers = Json::decode(file_get_contents(Yii::$app->basePath . '/data/engineers.json'));
        $filtered_item = array_filter($engineers, function ($value) use ($id) {
            return $value['id'] === $id;
        });

        $params['model'] = $filtered_item[$id - 1];

        return $this->render('details', $params);
    }
}
