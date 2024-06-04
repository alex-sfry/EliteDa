<?php

namespace app\controllers;

use app\models\ShipyardShips;
use Yii;
use app\models\forms\ShipyardShipsForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\PageCounter;

class ShipyardShipsController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [PageCounter::class, ShipyardShipsBehavior::class]
        );
    }

    public function actionIndex(): string
    {
        /** @var PageCounter|ShipyardShipsBehavior|ShipyardShipsController $this */

        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;
        $params = [];

        $params['ships_error'] = '';
        $params['ref_error'] = '';
        $form_model = new ShipyardShipsForm();
        $params['form_model'] = $form_model;
        $params['ships_arr'] = $this->getShipsList();

        if (count($request->get()) > 2) {
            $params['get'] = $request->get();
            $session->set('ships', $request->get());
        } elseif ($session->get('ships')) {
            $params['get'] = $session->get('ships');
        }

        if ($request->get() || $session->get('ships')) {
            $request->isGet && $session->remove('ships_sort');

            $form_model->setAttributes($params['get']);
            $params['ships_error'] = $form_model->validate('cMainSelect') ? '' : 'is-invalid';
            $params['ref_error'] = $form_model->validate('refSystem') ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $ships_model = new ShipyardShips();
            $ships_model->setShipsArr($params['ships_arr']);
            $limit = 50;
            $provider = $ships_model->getShips($params['get'], $limit);
            $params['models']  = $ships_model->modifyModels($provider->getModels(), $params['get']);

            $sort = $provider->getSort();
            $params['ship_sort'] = null;
            $params['time_sort'] = null;
            $params['d_ly_sort'] = null;

            switch ($sort->attributeOrders) {
                case ArrayHelper::keyExists('ship', $sort->attributeOrders):
                    $params['ship_sort'] = ($sort->attributeOrders)['ship'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('time_diff', $sort->attributeOrders):
                    $params['time_sort'] = ($sort->attributeOrders)['time_diff'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('distance_ly', $sort->attributeOrders):
                    $params['d_ly_sort'] = ($sort->attributeOrders)['distance_ly'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                default:
                    $params['ship'] = null;
            }

            $params['sort'] = $sort;
            $params['sort_ship'] = $sort->createUrl('ship');
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $pagination = $provider->getPagination();

            if ($pagination->getPageCount() !== 0) {
                $params['page_count_info'] = $this->getPageCounter($pagination);
            }

            $params['pagination'] = $pagination;

            if ($request->get('page')) {
                if ($session->get('ships_sort')) {
                    $sort->setAttributeOrders($session->get('ships_sort'));
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
                    'data' => $ships_model->modifyModels($provider->getModels()),
                    'params' => $pagination->params,
                    'totalCount' => $pagination->totalCount,
                    'attributeOrders' => $sort->attributeOrders,
                    'ships_sort' => $session->get('ships_sort')
                ];
                $response->send();
            }

            if ($request->get('sort')) {
                $session->set('ships_sort', $sort->attributeOrders);
                $provider->pagination->setPage(0);

                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'data' => $ships_model->modifyModels($provider->getModels()),
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

            $params['result'] = $this->renderPartial('ships_table', $params);

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
