<?php

namespace app\controllers;

use app\behaviors\SystemBehavior;
use app\models\search\MaterialTradersSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class MaterialTradersController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [SystemBehavior::class]
        );
    }

    public function actionIndex(): string
    {
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
                $distance_expr = $this->getDistanceToSystemExpression($session->get('mt')['refSysStation']);
            }
        }

        if (!isset($distance_expr) || !$distance_expr) {
            $distance_expr = $this->getDistanceToSystemExpression('', ['x' => 0, 'y' => 0, 'z' => 0]);
        }

        $searchModel = new MaterialTradersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $distance_expr);
        $dataProvider->pagination = ['pageSize' => 50];

        $dataProvider->sort->attributes['system.name'] = [
            'asc' => ['systems.name' => SORT_ASC],
            'desc' => ['systems.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['station.name'] = [
            'asc' => ['stations.name' => SORT_ASC],
            'desc' => ['stations.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;

        return $this->render('index', $params);
    }
}
