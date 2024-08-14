<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;

use function app\helpers\d;

class CommoditiesController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected \app\models\forms\CommoditiesForm $form_model,
        protected \app\models\Commdts $c_model,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [CommoditiesBehavior::class]
        );
    }

    public function actionIndex(): string
    {
        /** @var CommoditiesBehavior|CommoditiesController $this */

        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;

        $params = [];
        $params['c_error'] = '';
        $params['ref_error'] = '';
        $params['form_model'] = $this->form_model;
        $params['commodities_arr'] = $this->getCommodities();

        if (count($request->get()) > 2) {
            $request_data = $request->get();
            $session->set('c', $request_data);
        } elseif ($session->get('c')) {
            $request_data = $session->get('c');
        }

        if (isset($request_data) || $session->get('c')) {
            $request->isGet && $session->remove('c_sort');

            $this->form_model->load($request_data, '');
            $this->form_model->validate();

            $params['c_error'] = empty($this->form_model->getErrors('commodities_arr')) ? '' : 'is-invalid';
            $params['ref_error'] = empty($this->form_model->getErrors('refSystem')) ? '' : 'is-invalid';

            if ($this->form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $request_data['price_type'] = $request_data['buySellSwitch'] === 'buy' ? 'buy_price' : 'sell_price';
            $request_data['stock_demand'] = $request_data['buySellSwitch'] === 'buy' ? 'stock' : 'demand';
            $request_data['price_sort_direction'] = $request_data['buySellSwitch'] === 'buy' ? SORT_ASC : SORT_DESC;

            switch ($request_data['sortBy']) {
                case 'Updated_at':
                    $sort_attr = 'time_diff';
                    $sort_order = SORT_ASC;
                    break;
                case 'Distance':
                    $sort_attr = "distance_ly";
                    $sort_order = SORT_ASC;
                    break;
                default:
                    $sort_attr = $request_data['price_type'];
                    $sort_order = $request_data['price_sort_direction'];
            }

            $this->c_model->setAttributes(
                ArrayHelper::merge($request_data, ['sort_attr' => $sort_attr, 'sort_order' => $sort_order]),
                false
            );

            [$params['models'], $sort, $pagination] = $this->c_model->getPrices();

            if (empty($params['models'])) {
                return $this->render('index', $params);
            }

            $params['models'] = ArrayHelper::htmlEncode($params['models']);

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
            $price =  $request_data['buySellSwitch'] === 'sell' ? 'sell_price' : 'buy_price';
            $params['sort_price'] = $sort->createUrl($price);
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $params['pagination'] = $pagination;

            if ($request->get('page')) {
                $this->handlePagination($sort, $pagination, $session, $request, $params['models']);
            }

            if ($request->get('sort')) {
                $this->handleSort($sort, $pagination, $session, $request, $params['models']);
            }

            $params['buy_sell_switch'] =  $request_data['buySellSwitch'];

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }

    protected function handlePagination(
        Sort $sort,
        Pagination $pagination,
        Session $session,
        Request $request,
        array $models
    ): void {
        if ($session->get('c_sort')) {
            $sort->setAttributeOrders($session->get('c_sort'));
        }

        $pagination->setPage($request->get('page') - 1);
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = [
            'limit' => $pagination->pageSize,
            'links' => $pagination->getLinks(),
            'page' => $pagination->getPage(),
            'lastPage' => $pagination->pageCount,
            'data' => $models,
            'totalCount' => $pagination->totalCount,
        ];

        $response->send();
    }

    protected function handleSort(
        Sort $sort,
        Pagination $pagination,
        Session $session,
        Request $request,
        array $models
    ): void {
        $session->set('c_sort', $sort->attributeOrders);
        $pagination->setPage(0);
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = [
            'data' => $models,
            'attributeOrders' => $sort->attributeOrders,
            'links' => $pagination->getLinks(),
            'lastPage' => $pagination->pageCount,
            'totalCount' => $pagination->totalCount,
            'sortUrl' => $sort->createUrl(ltrim($request->get('sort'), '-')),
            'page' => $pagination->getPage(),
            'limit' => $pagination->pageSize,
            'totalCount' => $pagination->totalCount
        ];

        $response->send();
    }
}
