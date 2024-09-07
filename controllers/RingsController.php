<?php

namespace app\controllers;

use app\models\forms\RingsForm;

use function app\helpers\d;

class RingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        \Yii::$app->session->destroy();
        $form_model = new RingsForm();
        $params['form_model'] = $form_model;
        $params['ref_error'] = '';

        if (empty($request->get()) && empty($session->get('r'))) {
            return $this->render('index', $params);
        }
        if (!empty($request->get())) {
            $session->set('r', $request->get());
        }
        if (!$form_model->load($session->get('r'), '') || !$form_model->validate()) {
            $params['ref_error'] = !empty($form_model->getErrors('refSystem')) ? 'is-invalid' : '';
        }

        d($session->get('r'), false);
        // d($form_model->getErrors(), false);

        return $this->render('index', $params);
    }
}
