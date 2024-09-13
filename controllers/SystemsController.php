<?php

namespace app\controllers;

use app\models\ar\Systems;
use app\models\forms\SystemsAdvancedForm;
use app\models\forms\SystemsNameForm;
use app\services\SystemsService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;

class SystemsController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = $this->request;
        $session->open();
        // $session->destroy();
        $by_name_form = new SystemsNameForm();
        $params['by_name_form'] = $by_name_form;
        $adv_form = new SystemsAdvancedForm();
        $params['adv_form'] = $adv_form;
        $params['c'] = 0;

        if (array_key_exists('sysNameBtn', $request->get())) {
            $session->set('sys_name', $request->get());

            if ($by_name_form->load($session->get('sys_name'), '') && $by_name_form->validate()) {
                $service = new SystemsService($by_name_form->attributes);
                $models = $service->findSystemsByName()->limit(100)->asArray()->cache(86400)->all();
            }
        }

        if (array_key_exists('advFormBtn', $request->get())) {
            $session->set('adv_form', $request->get());

            if ($adv_form->load($session->get('adv_form'), '') && $adv_form->validate()) {
                $service = new SystemsService($adv_form->attributes);
                $models = $service->findSystems()->orderBy('distance')->limit(100)->asArray()->cache(86400)->all();
            }
        }

        $params['by_name_form_values'] = $session->get('sys_name') ?? $by_name_form->attributes;
        $params['adv_form_values'] = $session->get('adv_form') ?? $adv_form->attributes;

        if (isset($models) && !empty([$models])) {
            $params['models'] = $models;
        }

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id): string
    {
        !$id && throw new NotFoundHttpException();

        $model = Systems::find()
            ->details((int)$id)
            ->cache(86400)
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
                ->cache(86400)
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send();
        }
    }
}
