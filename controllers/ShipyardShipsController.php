<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use app\behaviors\ShipyardShipsBehavior;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\Request;
use yii\web\Session;

class ShipyardShipsController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected \app\models\forms\ShipyardShipsForm $form_model,
        protected \app\models\ShipyardShips $ships_model,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [ShipyardShipsBehavior::class]
        );
    }

    public function actionIndex(): string
    {
        /** @var ShipyardShipsBehavior|ShipyardShipsController $this */

        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;
        $params = [];

        $params['ships_error'] = '';
        $params['ref_error'] = '';
        $params['form_model'] = $this->form_model;
        $params['ships_arr'] = $this->getShipsList();

        if (count($request->get()) > 2) {
            $request_data = $request->get();
            $session->set('ships', $request_data);
        } elseif ($session->get('ships')) {
            $request_data = $session->get('ships');
        }

        if (isset($request_data) || $session->get('ships')) {
            $request->isGet && $session->remove('ships_sort');

            $this->form_model->load($request_data, '');
            $this->form_model->validate();

            $params['ships_error'] = $this->form_model->validate('cMainSelect') ? '' : 'is-invalid';
            $params['ref_error'] = $this->form_model->validate('refSystem') ? '' : 'is-invalid';

            if ($this->form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            switch ($request_data['sortBy']) {
                case 'Updated_at':
                    $sort_attr = 'time_diff';
                    $sort_order = SORT_ASC;
                    break;
                case 'Distance':
                    $sort_attr = 'distance_ly';
                    $sort_order = SORT_ASC;
                    break;
                default:
                    $sort_attr = 'distance_ly';
                    $sort_order = SORT_ASC;
            }

            $this->ships_model->setAttributes(
                ArrayHelper::merge($request_data, ['sort_attr' => $sort_attr, 'sort_order' => $sort_order]),
                false
            );

            $this->ships_model->setShipsArr($params['ships_arr']);

            [$params['models'], $sort, $pagination] = $this->ships_model->getShips();

            if (empty($params['models'])) {
                return $this->render('index', $params);
            }

            $params['models'] = ArrayHelper::htmlEncode($params['models']);

            $params['ship_sort'] = null;
            $params['time_sort'] = null;
            $params['d_ly_sort'] = null;

            switch ($sort->attributeOrders) {
                case ArrayHelper::keyExists('time_diff', $sort->attributeOrders):
                    $params['time_sort'] = ($sort->attributeOrders)['time_diff'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                case ArrayHelper::keyExists('distance_ly', $sort->attributeOrders):
                    $params['d_ly_sort'] = ($sort->attributeOrders)['distance_ly'] === 4 ? 'sorted asc' : 'sorted desc';
                    break;
                default:
                    $params['distance_ly'] = null;
            }

            $params['sort'] = $sort;
            $params['sort_updated'] = $sort->createUrl('time_diff');
            $params['sort_dist_ly'] = $sort->createUrl('distance_ly');

            $params['pagination'] = $pagination;

            if ($request->get('page')) {
                $this->handlePagination($sort, $pagination, $session, $request, $params['models']);
            }

            if ($request->get('sort')) {
                $this->handleSort($sort, $pagination, $session, $request, $params['models']);
            }

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
