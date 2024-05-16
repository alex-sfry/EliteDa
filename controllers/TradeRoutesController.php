<?php

namespace app\controllers;

use app\behaviors\PageCounter;
use app\models\forms\TradeRoutesForm;
use app\models\TradeRoutes;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\Controller;

class TradeRoutesController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [PageCounter::class]
        );
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;

        $params  = [];
        $params['ref_error'] = '';
        $params['cargo_error'] = '';
        $params['profit_error'] = '';
        $form_model = new TradeRoutesForm();
        $params['form_model'] = $form_model;

        if (count($request->get()) > 0) {
            $params['get'] = $request->get();
            $session->set('tr', $request->get());
        } elseif ($session->get('tr')) {
            $params['get'] = $session->get('tr');
        }

        if ($request->get() || $session->get('tr')) {
            $form_model->setAttributes($params['get']);
            $params['ref_error'] =  $form_model->validate('refSysStation') ? '' : 'is-invalid';
            $params['cargo_error'] =  $form_model->validate('cargo') ? '' : 'is-invalid';
            $params['profit_error'] =  $form_model->validate('profit') ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                $params['errors'] = $form_model;
                return $this->render('index', $params);
            }

            $params['get']['ref_system'] = StringHelper::explode($session->get('tr')['refSysStation'], ' / ', true)[0];
            $params['get']['ref_station'] = StringHelper::explode(
                $session->get('tr')['refSysStation'],
                ' / ',
                true
            )[1];

            $limit = 20;

            $tr_model = new TradeRoutes($params['get']);

            $data_dir = $tr_model->getData($limit);
            $pagination = $data_dir->getPagination();
            $params['models'] = $data_dir->getModels();

            if (isset($params['get']['roundTrip'])) {
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

            if ($pagination->getPageCount() !== 0) {
                $params['page_count_info'] = $this->getPageCounter($pagination);
            }

            $params['pagination'] = $pagination;
            $params['result'] = $this->renderPartial('tr_result', $params);
        }

        return $this->render('index', $params);
    }
}
