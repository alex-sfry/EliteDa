<?php

namespace app\controllers;

use app\models\Systems;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SystemsController extends Controller
{
    public function actionSystem(): void
    {
        $request = Yii::$app->request;
        $get_param = $request->get('sys');

        if (!$get_param) {
            throw new NotFoundHttpException();
        } else {
            $data = Systems::find()
                ->select('name as system')
                ->where(['like', 'name', "$get_param%", false])
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
