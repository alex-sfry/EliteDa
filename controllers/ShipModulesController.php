<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\forms\ShipModulesForm;
use app\services\ShipModulesService;

use function app\helpers\d;

class ShipModulesController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = $this->request;
        $session->open();
        // $session->destroy();
        $form = new ShipModulesForm();
        $params['form'] = $form;
        $service = new ShipModulesService();
        $params['module_names'] = $service->modules_list;

        if (array_key_exists('formBtn', $request->get())) {
            $session->set('mod_form', $request->get());
        }

        if (!empty($session->get('mod_form'))) {
            if ($form->load($session->get('mod_form'), '') && $form->validate()) {
                $service->form = $form->attributes;
                $models = $service->findModules()->orderBy('distance')->limit(100)->asArray()->cache(600)->all();
            }
        }

        $params['form_values'] = $session->get('mod_form') ?? $form->attributes;

        if (isset($models) && !empty([$models])) {
            $params['models'] = $models;
        }

        return $this->render('index', $params);
    }
}
