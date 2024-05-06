<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\PageCounter;
use app\models\Commdts;
use app\models\forms\CommoditiesForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class CommoditiesController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [PageCounter::class, CommoditiesBehavior::class]
        );
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;

        $params = [];
        $params['c_error'] = '';
        $params['ref_error'] = '';
        $form_model = new CommoditiesForm();
        $params['form_model'] = $form_model;
        $params['commodities_arr'] = $this->getCommodities();

        if (count($request->get()) > 0) {
            $params['get'] = $request->get();
            $session->set('c', $request->get());
        } else {
            $params['get'] = $session->get('c');
        }

        if ($request->isGet || $params['get']) {
            $request->isGet && $session->remove('c_sort');

            if (isset($params['get']['_csrf'])) {
                unset($params['get']['_csrf']);
            }

            $form_model->setAttributes($params['get']);
            $params['c_error'] = $form_model->validate('commodities') ? '' : 'is-invalid';
            $params['ref_error'] = $form_model->validate('refSystem', false) ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $c_model = new Commdts();
            $limit = 50;
            $provider = $c_model->getPrices($params['get']['refSystem'], $params['get'], $limit);
            $params['models']  = $c_model->modifyModels($provider->getModels());

            $sort = $provider->getSort();
            $params['price_sort'] = null;
            $params['time_sort'] = null;
            $params['d_ly_sort'] = null;

            switch ($sort->attributeOrders) {
                case ArrayHelper::keyExists('buy_price', $sort->attributeOrders):
                    $params['price_sort'] = ($sort->attributeOrders)['buy_price'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('sell_price', $sort->attributeOrders):
                    $params['price_sort'] = ($sort->attributeOrders)['sell_price'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('time_diff', $sort->attributeOrders):
                    $params['time_sort'] = ($sort->attributeOrders)['time_diff'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('distance_ly', $sort->attributeOrders):
                    $params['d_ly_sort'] = ($sort->attributeOrders)['distance_ly'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                default:
                    $params['price_sort'] = null;
            }

            $params['sort'] = $sort;
            $price =  $params['get']['buySellSwitch'] === 'sell' ? 'sell_price' : 'buy_price';
            $params['sort_price'] = $sort->createUrl($price);
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $pagination = $provider->getPagination();

            if ($pagination->getPageCount() !== 0) {
                $params['page_count_info'] = $this->getPageCounter($pagination);
            }

            $params['pagination'] = $pagination;

            if ($request->get('page')) {
                if ($session->get('c_sort')) {
                    $sort->setAttributeOrders($session->get('c_sort'));
                }

                $pagination->setPage($request->get('page') - 1);
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'limit' => $limit,
                    'links' => $pagination->getLinks(),
                    'page' => $pagination->getPage(),
                    'lastPage' => $pagination->pageCount,
                    'data' => $c_model->modifyModels($provider->getModels()),
                    'params' => $pagination->params,
                    'totalCount' => $pagination->totalCount,
                    'attributeOrders' => $sort->attributeOrders,
                    'c_sort' => $session->get('c_sort')
                ];
                $response->send();
            }

            if ($request->get('sort')) {
                $session->set('c_sort', $sort->attributeOrders);
                $provider->pagination->setPage(0);

                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'data' => $c_model->modifyModels($provider->getModels()),
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

            $params['result'] = $this->renderPartial('c_table', $params);

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
