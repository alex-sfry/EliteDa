<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

use function app\helpers\d;

class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    public function actionLogin(): Response|string
    {
        $model = new LoginForm();
        $model->referer = isset(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login() && Yii::$app->request->hostName === HOST_NAME) {
                return $this->redirect('/admin');
            }
        }

        return $this->render('@app/views/site/user/login', [
            'model' => $model,
        ]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionSignup(): string
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'User account created.');
            return $this->render('@app/views/site/user/signup_success', []);
        }

        return $this->render('@app/views/site/user/signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
