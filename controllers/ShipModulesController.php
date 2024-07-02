<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use app\behaviors\ShipModulesBehavior;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\Request;
use yii\web\Session;

use function app\helpers\d;

class ShipModulesController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected \app\models\forms\ShipModulesForm $form_model,
        protected \app\models\ShipMods $mod_model,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [ShipModulesBehavior::class]
        );
    }

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

        $params['form_model'] = $this->form_model;
        $params['ship_modules_arr'] = $this->getShipModules();

        if (count($request->get()) > 2) {
            $params['get'] = $request->get();
            $session->set('mod', $request->get());
        } elseif ($session->get('mod')) {
            $params['get'] = $session->get('mod');
        }

        if (isset($params['get']) || $session->get('mod')) {
            $request->isGet && $session->remove('mod_sort');

            $this->form_model->setAttributes($params['get']);
            $params['mod_error'] = $this->form_model->validate('cMainSelect') ? '' : 'is-invalid';
            $params['ref_error'] = $this->form_model->validate('refSystem', false) ? '' : 'is-invalid';

            if ($this->form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $this->mod_model->setMods($params['ship_modules_arr']);

            switch ($params['get']['sortBy']) {
                case 'Updated_at':
                    $sort_attr = 'time_diff';
                    $sort_order = SORT_ASC;
                    break;
                case 'Distance':
                    $sort_attr = "distance_ly";
                    $sort_order = SORT_ASC;
                    break;
                default:
                    $sort_attr = 'module';
                    $sort_order = SORT_ASC;
            }

            $sort = new Sort([
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'module'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order
                ],
            ]);

            $query = $this->mod_model->getModules($params['get']);
            $total_count = $query->count();

            $pagination = new Pagination([
                'totalCount' => $total_count,
                'pageSizeLimit' => [0, 50],
                'defaultPageSize' => 50,
            ]);

            $query = $this->mod_model->getModules(
                $params['get'],
                $pagination->pageSize,
                $sort->orders,
                $pagination->offset
            );

            $params['models']  = ArrayHelper::htmlEncode(
                $this->mod_model->modifyModels($query->all(), $params['get'])
            );

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
