<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\ShipModulesBehavior;
use app\behaviors\StationBehavior;
use app\models\Markets;
use app\models\ShipMods;
use app\models\ShipModules;
use app\models\Shipyard;
use app\models\StationMarket;
use app\models\Stations;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
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
     * @param int $id
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

        $services['market'] = Markets::find()
            ->where(['market_id' => $model['market_id']])
            ->asArray()
            ->count();

        $services['modules'] = ShipModules::find()
            ->where(['market_id' => $model['market_id']])
            ->asArray()
            ->count();

        $services['ships'] = Shipyard::find()
            ->where(['market_id' => $model['market_id']])
            ->asArray()
            ->count();

        return $this->render('details', [
            'model' => $model,
            'pad_size' => $this->landingPadSizes[$model['type']],
            'services' => $services
         ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionShipModules(int $id, ShipMods $ship_modules, string $cat = 'hardpoint'): string
    {
        $id = (int)$id;

        $station = Stations::find()
            ->where(['market_id' => $id])
            ->one();

        $station_name = $station['name'];

        // $ship_modules = new ShipMods($this->getShipModules());
        $ship_modules->setMods($this->getShipModules());
        $models = $ship_modules->getStationModules($id, $cat);
        $req = new Request();

        return $this->render('outfitting', [
            'models' => $models,
            'station_name' => $station_name,
            'commodities_req_arr' => $this->getCommoditiesReqArr(['Gold']),
            'req' => $req->get(),
            'cat' => $cat,
            'market_id' => $id
         ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionMarket(int $id, StationMarket $market): string
    {
        $id = (int)$id;

        $station = Stations::find()
            ->select('name')
            ->where(['market_id' => $id])
            ->asArray()
            ->one();

        return $this->render('market', [
            'model' => $market->getMarket($id),
            'station_name' => $station['name'],
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
