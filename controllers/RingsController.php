<?php

namespace app\controllers;

use app\behaviors\SystemBehavior;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RingsController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [SystemBehavior::class]
        );
    }

    public function actionIndex(\app\models\search\RingsSearch $searchModel): string
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
        }

        if (!isset($distance_expr) || !$distance_expr) {
            $distance_expr = new Expression(
                "ROUND(SQRT(POW((rings.x - 0), 2) + POW((rings.y - 0), 2) + POW((rings.z - 0), 2)), 2)"
            );
        }

        $dataProvider = $searchModel->search($this->request->queryParams, $distance_expr);
        $dataProvider->pagination = ['pageSize' => 50];

        $params['queryParams'] = $this->request->queryParams;

        $dataProvider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['distance' => SORT_ASC];

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;

        return $this->render('index', $params);
    }
}
