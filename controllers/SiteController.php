<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\EntryForm;
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

    // /**
    //  * @return string
    //  */
    // public function actionEntry(): string
    // {
    //     $model = new EntryForm();

    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         // valid data received in $model

    //         // do something meaningful here about $model ...

    //         return $this->render('entry-confirm', ['model' => $model]);
    //     } else {
    //         // either the page is initially displayed or there is some validation error
    //         return $this->render('entry', ['model' => $model]);
    //     }
    // }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
           'model' => $model,
        ]);
    }
}
