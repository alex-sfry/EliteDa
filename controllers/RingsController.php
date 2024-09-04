<?php

namespace app\controllers;

use app\models\forms\RingsForm;

use function app\helpers\d;

class RingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $form_model = new RingsForm();

        if (empty(\Yii::$app->request->get())) {
            $ref_error = '';
            return $this->render('index', ['form_model' => $form_model, 'ref_error' => $ref_error]);
        }

        $form_model->load(\Yii::$app->request->get(), '');
        $form_model->validate();
        $ref_error = !empty($form_model->getErrors('refSystem')) ? 'is-invalid' : '';

        return $this->render('index', ['form_model' => $form_model, 'ref_error' => $ref_error]);
    }
}
