<?php

namespace app\controllers;

use app\models\Commdts;
use Yii;
use app\models\CommoditiesForm;
use yii\helpers\VarDumper;
use yii\web\Controller;

class CommoditiesController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
        //        $session->destroy();
        $request = Yii::$app->request;

        $params = [];
        $params['c_error'] = '';
        $params['ref_error'] = '';
        $form_model = new CommoditiesForm();
        $params['form_model'] = $form_model;

        if (count($request->post()) > 0) {
            $params['post'] = $request->post();
            $session->set('c', $request->post());
        } else {
            $params['post'] = $session->get('c');
        }

        if ($request->isPost || $params['post']) {
            if (isset($params['post']['_csrf'])) {
                unset($params['post']['_csrf']);
            }

            $form_model->setAttributes($params['post']);
            $params['c_error'] = $form_model->validate('commodities') ? '' : 'is-invalid';
            $params['ref_error'] = $form_model->validate('refStation') ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $sys_name = explode(' / ', $params['post']['refStation'])[0];

            $c_model = new Commdts();
            $provider = $c_model->getPrices($sys_name, $params['post']['commodities']);
            $models = $provider->getModels();
            $result = $c_model->modifyModels($models);

            $pagination = $provider->getPagination();
            $current_page = $pagination->getPage() + 1;
            $page_size = $pagination->getPageSize();
            $first_in_range = $page_size * $current_page - $page_size + 1;
            $last_in_range = $pagination->totalCount - $current_page * $page_size <= $page_size - 1 ?
                $pagination->totalCount : $page_size * $current_page;
            $params['page_count_info'] = "<div>$first_in_range-$last_in_range / $pagination->totalCount</div>";
            $params['pagination'] = $pagination;
            $params['provider'] = $provider;
            $params['models'] = $models;
            $params['result'] = $result;
            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
