<?php

namespace app\controllers;

use app\models\ar\Systems;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SystemsController extends Controller
{
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
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ArrayHelper::htmlEncode($data);

            $response->send();
        }
    }
}
