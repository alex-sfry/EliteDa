<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class AddtodbController extends Controller
{
    /**
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if ($action->id === 'materials') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex(): string
    {
        if (!Yii::$app->user->can('accessAddtodb')) {
            if (Yii::$app->request->isPost) {
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->statusCode = 403;
                $response->data =  ['error' => 'access denied'];
                $response->send();

//                throw new \yii\web\NotFoundHttpException;
            } else {
                return 'access denied';
            }
        }

        $params = [];

        return $this->render('index', $params);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionMaterials(): string|bool
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return 'Only POST requests are accepted';
        }
        if (
            !ArrayHelper::keyExists('grade', $request->post()[0], false) &&
            !ArrayHelper::keyExists('location', $request->post()[0], false)
        ) {
            return 'Incorrect request body(keys)';
        }
        if (!count($request->post()[0]) > 0 || count($request->post()[0]) !== 5) {
            return 'Incorrect request body(length)';
        }

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $request->post());

        Yii::$app->db->createCommand()
            ->batchInsert('materials', ['name', 'category', 'grade', 'type', 'location'], $batch_rows)
            ->execute();

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $request->post();
        $response->send();

        return true;
    }
}
