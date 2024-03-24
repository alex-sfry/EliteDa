<?php

namespace app\controllers;

use app\models\Commdts;
use Yii;
use app\models\CommoditiesForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class CommoditiesController extends Controller
{
    /**
     * @return string
     */
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

            $sys_name = $params['post']['refSystem'];

            $c_model = new Commdts();
            $provider = $c_model->getPrices($sys_name, $params['post']);
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

//            $params['price_sort_dir'] =
            $params['sort'] = $sort;

            $price =  $params['post']['buySellSwitch'] === 'sell' ? 'sell_price' : 'buy_price';
            $params['sort_price'] = $sort->createUrl($price);
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $pagination = $provider->getPagination();

            if ($pagination->getPageCount() !== 0) {
            /*calculations for pages info near pagination buttons*/
                $current_page = $pagination->getPage() + 1;
                $page_size = $pagination->getPageSize();
                $first_in_range = $page_size * $current_page - $page_size + 1;
                $last_in_range = $pagination->totalCount - ($current_page - 1) * $page_size <= $page_size - 1 ?
                    $pagination->totalCount : $page_size * $current_page;
                $params['page_count_info'] =
                    "<div class='text-light me-3'>$first_in_range-$last_in_range / $pagination->totalCount</div>";
            }

            $params['pagination'] = $pagination;
//            $params['provider'] = $provider;
//            $params['date'] = $models[0]['time_diff'];

            if ($request->get()) {
                $pagination->setPage($request->get('page') - 1);
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->data = [
                    'pagination' => $pagination,
                    'links' => $pagination->getLinks(),
                    'page' => $pagination->getPage(),
                    'lastPage' => $pagination->pageCount,
                    'data' => $params['models']
                ];
                $response->send();

//                return Json::encode([
//                    'pagination' => $pagination,
//                    'links' => $pagination->getLinks(),
//                    'data' => $params['models']
//                ]);
            }
            $params['result'] = $this->renderPartial('c_table', $params);
            return $this->render('index', $params);
        }

        return $this->render('index', $params);
    }
}
