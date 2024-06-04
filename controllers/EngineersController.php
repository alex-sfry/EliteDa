<?php

namespace app\controllers;

use app\models\search\EngineersSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use function app\helpers\d;

class EngineersController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new EngineersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if (empty($this->request->queryParams)) {
            $params['queryParams']['EngineersSearch'] = array_fill_keys(
                array_values($searchModel->activeAttributes()),
                null
            );
        } else {
            $params['queryParams'] = $this->request->queryParams;
        }

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id): string
    {
        !$id && throw new NotFoundHttpException();

        $id = (int)$id;

        $engineers = Json::decode(file_get_contents(Yii::$app->basePath . '/data/engineers.json'));
        $filtered_item = array_filter($engineers, function ($value) use ($id) {
            return $value['id'] === $id;
        });

        $params['model'] = $filtered_item[$id - 1];

        return $this->render('details', $params);
    }
}
