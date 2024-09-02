<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\models\Commdts;
use app\models\forms\CommoditiesForm;
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

        $form_model = new CommoditiesForm();

        $params = [];
        $params['c_error'] = '';
        $params['ref_error'] = '';
        $params['form_model'] = $form_model;
        $params['commodities_arr'] = $this->getCommodities();

        if (count($request->get()) > 2) {
            $request_data = $request->get();
            $session->set('c', $request_data);
        } elseif ($session->get('c')) {
            $request_data = $session->get('c');
        }

        if (isset($request_data) || $session->get('c')) {
            $request->isGet && $session->remove('c_sort');

            $form_model->load($request_data, '');
            $form_model->validate();

            $params['c_error'] = empty($form_model->getErrors('commodities_arr')) ? '' : 'is-invalid';
            $params['ref_error'] = empty($form_model->getErrors('refSystem')) ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $request_data['price_type'] = $request_data['buySellSwitch'] === 'buy' ? 'buy_price' : 'sell_price';
            $request_data['stock_demand'] = $request_data['buySellSwitch'] === 'buy' ? 'stock' : 'demand';
            $price_sort_direction = $request_data['buySellSwitch'] === 'buy' ? SORT_ASC : SORT_DESC;

            $model = new Commdts();
            $model->setAttributes($request_data, false);
            $model->setCommodities($params['commodities_arr']);

            $query = $model->getQuery();
            $total_count = $query->cache(3600)->count();

            /** pagination */
            $pagination = new Pagination([
                'totalCount' => $total_count,
                'pageSizeLimit' => [0, 50],
                'defaultPageSize' => 50,
            ]);

            $limit = $pagination->pageSize;
            $offset = $pagination->offset;
            /** end of pagination */

            /** sorting */
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
                    $sort_order = $price_sort_direction;
            }

            $sort = new Sort([
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'sell_price',
                    'buy_price'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order
                ],
            ]);

            $order = $sort->orders;
            /** end of sorting */

            $query->orderBy($order);
            $query->offset($offset);
            $query->limit($limit);

            $params['models'] = $model->modifyModels($query->cache(3600)->all());

            if (empty($params['models'])) {
                return $this->render('index', $params);
            }

            $params['models'] = ArrayHelper::htmlEncode($params['models']);

            $params['sort'] = $sort;
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
