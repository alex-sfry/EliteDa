<?php

namespace app\controllers;

use app\behaviors\PageCounter;
use app\models\forms\TradeRoutesForm;
use app\models\TradeRoutes;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\Controller;

use function app\helpers\d;

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
            $data = $tr_model->getTradeRoutes();

            if (gettype($data) === 'string') {
                $params['model_error'] = $data;
                return $this->render('index', $params);
            }

            $params['source_station'] = ArrayHelper::remove($data, 'source_station');

            switch ($params['get']['sortBy']) {
                case 'Updated_at':
                    $sort_attr = 'target_time_diff';
                    $sort_order = SORT_ASC;
                    break;
                case 'Distance':
                    $sort_attr = "distance";
                    $sort_order = SORT_ASC;
                    break;
                default:
                    $sort_attr =  'profit';
                    $sort_order = SORT_DESC;
            }

            $data_provider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => $limit,
                ],
                'sort' => [
                    'attributes' => [
                        'profit',
                        'distance',
                        'target_time_diff'
                    ],
                    'defaultOrder' => [
                        $sort_attr => $sort_order
                    ],
                ],
            ]);

            $pagination = $data_provider->getPagination();
            $params['models'] = $data_provider->getModels();

            if (count($params['models']) < 1) {
                $params['model_error'] = 'Trade routes not found';
                return $this->render('index', $params);
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
