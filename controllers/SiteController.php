<?php

namespace app\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    // /**
    //  * {@inheritdoc}
    //  */
    // public function behaviors(): array
    // {
    //     return [
    //         'access' => [
    //            'class' => AccessControl::class,
    //            'only' => ['logout'],
    //            'rules' => [
    //                [
    //                    'actions' => ['logout'],
    //                    'allow' => true,
    //                    'roles' => ['@'],
    //                ],
    //            ],
    //         ],
    //         'verbs' => [
    //            'class' => VerbFilter::class,
    //            'actions' => [
    //                'logout' => ['post'],
    //            ],
    //         ],
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                // 'imageLibrary' => 'gd'
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     */
    public function actionContact(\app\models\forms\ContactForm $model): Response|string
    {
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
           'model' => $model,
        ]);
    }
}
