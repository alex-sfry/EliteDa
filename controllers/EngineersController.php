<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use function app\helpers\d;

class EngineersController extends Controller
{
    public function __construct($id, $module, protected \app\models\search\EngineersSearch $searchModel, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $dataProvider = $this->searchModel->search($this->request->queryParams);

        if (empty($this->request->queryParams) || !isset($this->request->queryParams['EngineersSearch'])) {
            $params['queryParams']['EngineersSearch'] = array_fill_keys(
                array_values($this->searchModel->activeAttributes()),
                null
            );
        } else {
            $params['queryParams'] = ArrayHelper::htmlEncode($this->request->queryParams);
        }

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $this->searchModel;

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

        $params['model'] = ArrayHelper::htmlEncode($filtered_item[$id - 1]) ;

        return $this->render('details', $params);
    }
}
