<?php

namespace app\controllers;

use app\behaviors\SystemBehavior;
use app\models\ar\Rings;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;

use function app\helpers\d;

class RingsController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [SystemBehavior::class]
        );
    }

    public function actionIndex(): string
    {
        /** @var SystemBehavior|RingsController $this */

        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;

        if (count($request->get()) > 0) {
            if (isset($request->get()['refSysStation']) && $request->get()['refSysStation']) {
                $session->set('mt', $request->get());
            } else {
                $session->set('mt', ['refSysStation' => 'Sol']);
            }
        } else {
            !isset($session->get('mt')['refSysStation']) && $session->set('mt', ['refSysStation' => 'Sol']);
        }

        if (isset($session->get('mt')['refSysStation'])) {
            if ($session->get('mt')['refSysStation'] !== '') {
                $ref_coords = $this->getCoords($session->get('mt')['refSysStation']);
                $ref_coords && extract($ref_coords);
                $distance_expr = new Expression(
                    "ROUND(SQRT(POW((rings.x - $x), 2) + POW((rings.y - $y), 2) + POW((rings.z - $z), 2)), 2)"
                );
            }

            $params['refSysStation'] = $session->get('mt')['refSysStation'];
        }

        if (!isset($distance_expr) || !$distance_expr) {
            $distance_expr = new Expression(
                "ROUND(SQRT(POW((rings.x - 0), 2) + POW((rings.y - 0), 2) + POW((rings.z - 0), 2)), 2)"
            );
        }

        $rings = Rings::find();
        $rings
            ->select([
                'name',
                'system_name',
                'distance_to_arrival',
                "$distance_expr as distance_ly"
            ])
            ->where(['not', ['x' => null]])
            ->andWhere(['type' => 'Metallic'])
        ;

        $total_count = $rings->count();

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
        $sort = new Sort([
            'attributes' => [
                'distance_ly'
            ],
            'defaultOrder' => [
                'distance_ly' => SORT_ASC
            ],
        ]);

        $order = $sort->orders;
        /** end of sorting */

        $rings->orderBy($order);
        $rings->offset($offset);
        $rings->limit($limit);

        $params['models'] = $rings->asArray()->cache(3600)->all();
        $params['pagination'] = $pagination;
        $params['sort'] = $sort;
        $params['queryParams'] = $request->queryParams;

        if ($request->get('page')) {
            $this->handlePagination($sort, $pagination, $session, $request, $params['models']);
        }

        if ($request->get('sort')) {
            $this->handleSort($sort, $pagination, $session, $request, $params['models']);
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
