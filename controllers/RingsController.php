<?php

namespace app\controllers;

use app\models\forms\RingsForm;
use app\services\RingsService;

use function app\helpers\d;

class RingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        // $session->destroy();
        $form_model = new RingsForm();
        $params['form_model'] = $form_model;

        if (empty($request->get()) && empty($session->get('r'))) {
            return $this->render('index', $params);
        }

        !empty($request->get()) && $session->set('r', $request->get());

        if (!$form_model->load($session->get('r'), '') || !$form_model->validate()) {
            return $this->render('index', $params);
        }

        $service = new RingsService($form_model->attributes);
        $service->findRings();
        $params['pagination'] = $service->provider->getPagination();
        $params['sort'] = $service->provider->getSort();
        $params['models'] = $service->postprocessData($service->provider->getModels());

        return $this->render('index', $params);
    }
}
