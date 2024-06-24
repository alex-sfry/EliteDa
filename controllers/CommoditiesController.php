<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

use function app\helpers\d;

class CommoditiesController extends Controller
{
    public function __construct(
        $id,
        $module,
        private \app\models\forms\CommoditiesForm $form_model,
        private \app\models\Commdts $c_model,
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
            $get = $request->get();
            $session->set('c', $request->get());
        } elseif ($session->get('c')) {
            $get = $session->get('c');
        }

        if ($request->get() || $session->get('c')) {
            $request->isGet && $session->remove('c_sort');

            $this->form_model->setAttributes($get);
            $params['c_error'] = $this->form_model->validate('commodities') ? '' : 'is-invalid';
            $params['ref_error'] = $this->form_model->validate('refSystem', false) ? '' : 'is-invalid';

            if ($this->form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            if ($get['buySellSwitch'] === 'buy') {
                $price_type = 'buy_price';
                $stock_demand = 'stock';
                $price_sort_direction = SORT_ASC;
            } else {
                $price_type = 'sell_price';
                $stock_demand = 'demand';
                $price_sort_direction = SORT_DESC;
            }

            switch ($get['sortBy']) {
                case 'Updated_at':
                    $sort_attr = 'time_diff';
                    $sort_order = SORT_ASC;
                    break;
                case 'Distance':
                    $sort_attr = "distance_ly";
                    $sort_order = SORT_ASC;
                    break;
                default:
                    $sort_attr = $price_type;
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

            $query = $this->c_model->getPrices($get, $price_type, $stock_demand);
            $total_count = $query->count();

            $pagination = new Pagination([
                'totalCount' => $total_count,
                'pageSizeLimit' => [0, 50],
                'defaultPageSize' => 50,
            ]);

            $query = $this->c_model->getPrices(
                $get,
                $price_type,
                $stock_demand,
                $pagination->pageSize,
                $sort->orders,
                $pagination->offset
            );

            $params['models']  = ArrayHelper::htmlEncode($this->c_model->modifyModels($query->all()));
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
            $price =  $get['buySellSwitch'] === 'sell' ? 'sell_price' : 'buy_price';
            $params['sort_price'] = $sort->createUrl($price);
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $params['pagination'] = $pagination;

            if ($request->get('page')) {
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
                    'data' => $params['models'],
                    'totalCount' => $pagination->totalCount,
                ];
                $response->send();
            }

            if ($request->get('sort')) {
                $session->set('c_sort', $sort->attributeOrders);
                $pagination->setPage(0);
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'data' => $params['models'],
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

            $params['buy_sell_switch'] =  $get['buySellSwitch'];

            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
