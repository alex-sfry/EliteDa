<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use function app\helpers\d;

class AdminController extends Controller
{
    /**
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction(mixed $action): bool
    {
        if (!Yii::$app->user->can('accessAdmin')) {
            // throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
            $this->redirect(['user/login'], 302);
        }

        return parent::beforeAction($action);
    }

    public function actionIndex(): string
    {

        return $this->render('index', []);
    }
}
