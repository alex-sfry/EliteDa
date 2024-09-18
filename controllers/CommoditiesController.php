<?php

namespace app\controllers;

use Yii;
use app\models\forms\CommoditiesForm;
use app\services\CommoditiesService;
use yii\web\Controller;

use function app\helpers\d;

class CommoditiesController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = $this->request;
        $session->open();
        // $session->destroy();
        $form = new CommoditiesForm();
        $params['form'] = $form;
        $service = new CommoditiesService();
        $params['commodity_names'] = $service->commodity_list;

        if (array_key_exists('formBtn', $request->get())) {
            $session->set('c_form', $request->get());
            $form->load($session->get('c_form'), '');

            if ($form->load($session->get('c_form'), '') && $form->validate()) {
                $service->form = $form->attributes;
                d(\Yii::$app->db->enableQueryCache, false);
                $models = $service->findCommodPrices()->limit(100)->asArray()->cache(600)->all();
            }
        }

        $params['form_values'] = $session->get('c_form') ?? $form->attributes;

        if (isset($models) && !empty([$models])) {
            $params['models'] = $models;
            $params['price'] = $service->price_type;
            $params['stock_demand'] = $service->stock_demand;
            $params['service'] = $service;
        }

        return $this->render('index', $params);
    }
}
