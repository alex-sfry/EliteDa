<?php

namespace app\controllers;

use app\models\Stations;
use app\models\Systems;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StationsController extends Controller
{
    /**
     * @return void
     * @throws NotFoundHttpException
     */
    public function actionSystemStation(): void
    {
        $request = Yii::$app->request;
        $get_param = $request->get('sys-st');

        if (!$get_param) {
            throw new NotFoundHttpException();
        } else {
            $data = Stations::find()
                ->select('systems.name as system, stations.name as station')
                ->innerJoin('systems', 'stations.system_id = systems.id')
                ->where(['like', 'stations.name', "$get_param%", false])
                ->orderBy('systems.name')
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send();
        }
    }
}
