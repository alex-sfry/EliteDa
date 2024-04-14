<?php

namespace app\controllers;

use app\models\search\EngineersSearch;
use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
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
//        $params['engineers'] = Json::decode(file_get_contents(Yii::$app->basePath . '/data/engineers.json'));

        return $this->render('index', $params);
    }

    public function actionDetails($id): void
    {
        $engineers = Json::decode(file_get_contents(Yii::$app->basePath . '/data/engineers.json'));
        $filtered_item = array_filter($engineers, function ($value) use ($id) {
            return stripos($value['id'], $id) !== false;
        });

        echo $filtered_item[$id - 1]['id'];

        VarDumper::dump($filtered_item, 10, true);
    }
}
