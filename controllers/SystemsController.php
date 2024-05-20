<?php

namespace app\controllers;

use app\models\Systems;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SystemsController extends Controller
{
    public function actionSystem($sys): void
    {
        if (!$sys) {
            throw new NotFoundHttpException();
        } else {
            $data = Systems::find()
                ->select('name as system')
                ->where(['like', 'name', "$sys%", false])
                ->orderBy('name')
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send();
        }
    }
}
