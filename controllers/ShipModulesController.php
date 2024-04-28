<?php

namespace app\controllers;

use app\models\ShipMods;
use Yii;
use app\models\forms\ShipModulesForm;
use yii\helpers\ArrayHelper;
// use yii\web\Response;
use yii\web\Controller;
use app\behaviors\ShipModulesBehavior;
use app\behaviors\PageCounter;
use yii\helpers\VarDumper;

class ShipModulesController extends Controller
{
     /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [PageCounter::class, ShipModulesBehavior::class]
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
        $params = [];

        $params['mod_error'] = '';
        $params['ref_error'] = '';
        $form_model = new ShipModulesForm();
        $params['form_model'] = $form_model;
        $params['ship_modules_arr'] = $this->getShipModules('first');

        if (count($request->post()) > 0) {
            $params['post'] = $request->post();
            $session->set('mod', $request->post());
        } else {
            $params['post'] = $session->get('mod');
        }

        if ($request->isPost || $params['post']) {
            $request->isPost && $session->remove('mod_sort');

            if (isset($params['post']['_csrf'])) {
                unset($params['post']['_csrf']);
            }

            $form_model->setAttributes($params['post']);
            $params['mod_error'] = $form_model->validate('cMainSelect') ? '' : 'is-invalid';
            $params['ref_error'] = $form_model->validate('refSystem', false) ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $sys_name = $params['post']['refSystem'];

            $c_model = new ShipMods($params['ship_modules_arr']);
            $limit = 50;
            $provider = $c_model->getModules($sys_name, $params['post'], $limit, $session->get('mod_sort'));
            $params['models']  = $c_model->modifyModels($provider->getModels(), $params['post']);

            $sort = $provider->getSort();
            $params['module_sort'] = null;
            $params['time_sort'] = null;
            $params['d_ly_sort'] = null;

            switch ($sort->attributeOrders) {
                case ArrayHelper::keyExists('module', $sort->attributeOrders):
                    $params['module_sort'] = ($sort->attributeOrders)['module'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('time_diff', $sort->attributeOrders):
                    $params['time_sort'] = ($sort->attributeOrders)['time_diff'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('distance_ly', $sort->attributeOrders):
                    $params['d_ly_sort'] = ($sort->attributeOrders)['distance_ly'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                default:
                    $params['module'] = null;
            }

            $params['sort'] = $sort;
            $params['sort_module'] = $sort->createUrl('module');
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $pagination = $provider->getPagination();

            if ($pagination->getPageCount() !== 0) {
                $params['page_count_info'] = $this->getPageCounter($pagination);
            }

            $params['pagination'] = $pagination;
            $params['result'] = $this->renderPartial('mod_table', $params);

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
