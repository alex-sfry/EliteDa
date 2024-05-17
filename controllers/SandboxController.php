<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class SandboxController extends Controller
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
        if (!Yii::$app->user->can('accessSandbox')) {
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
}
