<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\ShipModulesBehavior;
use app\behaviors\StationBehavior;
use app\models\Markets;
use app\models\ShipModules;
use app\models\Stations;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StationsController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                StationBehavior::class,
                CommoditiesBehavior::class,
                ShipModulesBehavior::class
            ]
        );
    }

    /**
     * @var int $id
     *
     * @return string
     */
    public function actionDetails(int $id): string
    {
        $id = (int)$id;

        $model = Stations::find()
            ->with(['system', 'economyId1', 'economyId2', 'allegiance'])
            ->where(['stations.id' => (int)$id])
            ->asArray()
            ->one();

        return $this->render('details', [
            'model' => $model,
            'pad_size' => $this->landingPadSizes[$model['type']]
         ]);
    }

    /**
     * @var int $id
     *
     * @return string
     */
    public function actionShipModules(int $id): string
    {
        $id = (int)$id;

        $model = Stations::find()
            ->with('shipModules')
            ->where(['market_id' => $id])
            ->asArray()
            ->one();

        foreach ($model['shipModules'] as $key => $value) {
            $model['shipModules'][$key]['name'] = isset($this->getShipModules()[strtolower($value['name'])]) ?
                $this->getShipModules()[strtolower($value['name'])] : $model['shipModules'][$key]['name'];
            $model['shipModules'][$key]['timestamp'] =
                Yii::$app->formatter->asRelativeTime($model['shipModules'][$key]['timestamp']);
            unset($model['shipModules'][$key]['market_id']);
        }

        return $this->render('outfitting', [
            'model' => $model,
            'station_name' => $model['name'],
         ]);
    }

    /**
     * @var int $id
     *
     * @return string
     */
    public function actionMarket(int $id): string
    {
        $id = (int)$id;

        $model = Stations::find()
            ->joinWith('markets', true, 'INNER JOIN')
            ->where(['and', "stations.market_id=$id", ['or', 'stock>0', 'demand>0']])
            ->asArray()
            ->one();

        foreach ($model['markets'] as $key => $value) {
            $model['markets'][$key]['name'] = isset($this->commodities[strtolower($value['name'])]) ?
                $this->commodities[strtolower($value['name'])] : $model['markets'][$key]['name'];
            $model['markets'][$key]['timestamp'] =
                Yii::$app->formatter->asRelativeTime($model['markets'][$key]['timestamp']);
            unset($model['markets'][$key]['market_id']);
        }

        return $this->render('market', [
            'model' => $model['markets'],
            'station_name' => $model['name'],
         ]);
    }

    /**
     * @return void
     * @throws NotFoundHttpException
     */
    public function actionSystemStation(): void
    {
        $request = Yii::$app->request;
        $get_param = $request->get('sys-st');

        if (!$get_param) {
            throw new NotFoundHttpException();
        } else {
            $data = Stations::find()
                ->select('systems.name as system, stations.name as station')
                ->innerJoin('systems', 'stations.system_id = systems.id')
                ->where(['like', 'stations.name', "$get_param%", false])
                ->orderBy('systems.name')
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send();
        }
    }
}
