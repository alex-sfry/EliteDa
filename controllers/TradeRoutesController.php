<?php

namespace app\controllers;

use app\models\TradeRoutesForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TradeRoutesController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
//        $session->destroy();
        $request = Yii::$app->request;
//        VarDumper::dump($request->post(), 10, true);
        $params  = [];
        $params['ref_error'] = '';
        $params['cargo_error'] = '';
        $params['profit_error'] = '';
        $form_model = new TradeRoutesForm();
        $params['form_model'] = $form_model;

        if (count($request->post()) > 0) {
            $params['post']  = $request->post();
            $session->set('tr', $request->post());
        } else {
            $params['post'] = $session->get('tr');
        }

        if ($request->isPost || $params['post']) {
            if (isset($params['post']['_csrf'])) {
                unset($params['post']['_csrf']);
            }

            $form_model->setAttributes($params['post']);
            $params['ref_error'] =  $form_model->validate('refSysStation') ? '' : 'is-invalid';
            $params['cargo_error'] =  $form_model->validate('cargo') ? '' : 'is-invalid';
            $params['profit_error'] =  $form_model->validate('profit') ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                $params['errors'] = $form_model;
                return $this->render('index', $params);
            }

//            $result = $trade_routes->getData();
        }

        return $this->render('index', $params);
    }
}
