<?php

namespace app\controllers;

use app\models\ShipMods;
use Yii;
use app\models\forms\ShipModulesForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use app\behaviors\ShipModulesBehavior;

use function app\helpers\d;

class ShipModulesController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [ShipModulesBehavior::class]
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function actionIndex(): string
    {
        /** @var ShipModulesBehavior|ShipModulesController $this */

        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;
        $params = [];

        $params['mod_error'] = '';
        $params['ref_error'] = '';
        $form_model = new ShipModulesForm();
        $params['form_model'] = $form_model;
        $params['ship_modules_arr'] = $this->getShipModules();

        if (count($request->get()) > 2) {
            $params['get'] = $request->get();
            $session->set('mod', $request->get());
        } elseif ($session->get('mod')) {
            $params['get'] = $session->get('mod');
        }

        if ($request->get() || $session->get('mod')) {
            $request->isGet && $session->remove('mod_sort');

            $form_model->setAttributes($params['get']);
            $params['mod_error'] = $form_model->validate('cMainSelect') ? '' : 'is-invalid';
            $params['ref_error'] = $form_model->validate('refSystem', false) ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $mod_model = new ShipMods();
            $mod_model->setMods($params['ship_modules_arr']);
            $limit = 50;
            $provider = $mod_model->getModules($params['get'], $limit);
            $params['models']  = ArrayHelper::htmlEncode(
                $mod_model->modifyModels($provider->getModels(), $params['get'])
            );

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
            $params['pagination'] = $pagination;

            if ($request->get('page')) {
                if ($session->get('mod_sort')) {
                    $sort->setAttributeOrders($session->get('mod_sort'));
                }
                $provider->setSort($sort);
                $pagination->setPage($request->get('page') - 1);
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'limit' => $limit,
                    'links' => $pagination->getLinks(),
                    'page' => $pagination->getPage(),
                    'lastPage' => $pagination->pageCount,
                    'data' => $mod_model->modifyModels($provider->getModels()),
                    'params' => $pagination->params,
                    'totalCount' => $pagination->totalCount,
                    'attributeOrders' => $sort->attributeOrders,
                    'mod_sort' => $session->get('mod_sort')
                ];
                $response->send();
            }

            if ($request->get('sort')) {
                $session->set('mod_sort', $sort->attributeOrders);
                $provider->pagination->setPage(0);

                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'data' => $mod_model->modifyModels($provider->getModels()),
                    'sort' => $sort,
                    'attributeOrders' => $sort->attributeOrders,
                    'links' => $pagination->getLinks(),
                    'lastPage' => $pagination->pageCount,
                    'totalCount' => $pagination->totalCount,
                    'sortUrl' => $sort->createUrl(ltrim($request->get('sort'), '-')),
                    'page' => $pagination->getPage(),
                    'limit' => $limit,
                    'totalCount' => $pagination->totalCount
                ];
                $response->send();
            }

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
