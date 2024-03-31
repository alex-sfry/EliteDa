<?php

namespace app\controllers;

use app\models\TradeRoutes;
use app\models\TradeRoutesForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
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
//            $request->isPost && $session->remove('c_sort');
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

            $params['post']['ref_system'] = StringHelper::explode($session->get('tr')['refSysStation'], ' / ', true)[0];
            $params['post']['ref_station'] = StringHelper::explode(
                $session->get('tr')['refSysStation'],
                ' / ',
                true
            )[1];

            $limit = 20;

            $tr_model = new TradeRoutes($params['post']);

            $data_dir = $tr_model->getData($limit);
            $pagination = $data_dir->getPagination();
            $params['models'] = $data_dir->getModels();

            if (isset($params['post']['roundTrip'])) {
                $target_market_ids = ArrayHelper::getColumn($params['models'], 'target_market_id');
                $params['models']  = $tr_model->modifyModels(
                    $tr_model->getResultWithRoundTrip(
                        $params['models'],
                        $tr_model->getRoundTrip($target_market_ids)->all()
                    )
                );
            } else {
                $params['models']  = $tr_model->modifyModels($params['models']);
            }

            $params['pagination'] = $pagination;
        }

        return $this->render('index', $params);
    }
}
