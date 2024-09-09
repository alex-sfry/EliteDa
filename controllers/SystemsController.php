<?php

namespace app\controllers;

use app\models\ar\Systems;
use app\models\forms\SystemsForm;
use app\models\search\SystemsInfoSearch;
use app\services\SystemsService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use function app\helpers\d;

class SystemsController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = \Yii::$app->request;
        $session->open();
        // $session->destroy();
        $form_model = new SystemsForm();
        $params['form_model'] = $form_model;
        !empty($request->get()) && $session->set('sys', $request->get());
        $get = $session->get('sys');

        if (!empty($get)) {
            $form_model->load($get, '');
            $form_model->validate();
        }

        $service = new SystemsService($form_model->attributes);
        $queryParams = $request->queryParams;
        $service->findSystems($queryParams);
        $params['queryParams'] = $service->queryParams;
        $params['dataProvider'] = $service->provider;
        $params['searchModel'] = $service->searchModel;

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id): string
    {
        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $model = Systems::find()
            ->with(['stations', 'economy', 'security', 'allegiance'])
            ->where(['systems.id' => (int)$id])
            ->cache(86400)
            ->asArray()
            ->one();

        !$model && throw new NotFoundHttpException();

        return $this->render('details', [
            'model' => ArrayHelper::htmlEncode($model)
        ]);
    }

    public function actionSystem(string $sys): void
    {
        if (!$sys) {
            throw new NotFoundHttpException();
        } else {
            $data = Systems::find()
                ->select('name as system')
                ->where(['like', 'name', "$sys%", false])
                ->orderBy('name')
                ->cache(86400)
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ArrayHelper::htmlEncode($data);

            $response->send();
        }
    }
}
