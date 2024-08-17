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
        protected \app\models\ShipyardShips $model,
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

            $this->model->setAttributes($request_data, false);
            $this->model->setShipsArr($params['ships_arr']);

            $query = $this->model->getQuery();
            $total_count = $query->count();

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
                    $sort_attr = 'distance_ly';
                    $sort_order = SORT_ASC;
            }

            $sort = new Sort([
                'attributes' => [
                    'distance_ly',
                    'time_diff'
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

            $params['models'] = $this->model->modifyModels($query->all());

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
