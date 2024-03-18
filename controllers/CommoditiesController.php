<?php

namespace app\controllers;

use app\models\Commodities;
use app\models\Markets;
use app\models\Stations;
use app\models\Systems;
use Yii;
use app\models\CommoditiesForm;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;

class CommoditiesController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $session->open();
//        $session->destroy();

        $request = Yii::$app->request;

        if (!$session->get('c') && $request->post()) {
            $session->set('c', $request->post());
            $post = $session->get('c');
        }

        $params  = [];
        $params['c_error'] = '';
        $params['ref_error'] = '';
        $form_model = new CommoditiesForm();
        $params['form_model'] = $form_model;

        if ($request->isPost || isset($post)) {
            $params['post'] = $post;

            if (isset($params['post']['_csrf'])) {
                unset($params['post']['_csrf']);
            }

            $form_model->setAttributes($post);
            $params['c_error'] =  $form_model->validate('commodities') ? '' : 'is-invalid';
            $params['ref_error'] =  $form_model->validate('refStation') ? '' : 'is-invalid';

            if ($form_model->hasErrors()) {
                return $this->render('index', $params);
            }

            $sys_name = explode(' / ', $post['refStation'])[0];

            $refCoords = Systems::find()
                ->select(['x', 'y', 'z'])
                ->where(['name' => $sys_name])
                ->one();

            $c_name = Commodities::find()
                ->select('symbol')
                ->where(['name' => $post['commodities']])
                ->asArray()
                ->all();

            $c_name = array_map(function ($elem) {
                return strtolower($elem['symbol']);
            }, $c_name);

            $prices = Markets::find()
                ->innerJoinWith('market.system')
                ->where(['markets.name' => $c_name])
                ->andWhere([
                    '<', "ROUND(SQRT(POW((systems.x - $refCoords->x), 2) + POW((systems.y - $refCoords->y), 2) + POW((systems.z - $refCoords->z), 2)), 2)", 10
                ]);

            $provider = new ActiveDataProvider([
                'query' => $prices,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            $params['pagination'] = $provider->getPagination();
            $params['provider'] = $provider->getModels();
        }

        return $this->render('index', $params);
    }
}
