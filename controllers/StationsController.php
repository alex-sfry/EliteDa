<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\ShipModulesBehavior;
use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\StationBehavior;
use app\models\ar\Markets;
use app\models\ar\MaterialTraders;
use app\models\ShipMods;
use app\models\ar\ShipModules;
use app\models\ShipyardShips;
use app\models\ar\Shipyard;
use app\models\StationMarket;
use app\models\ar\Stations;
use app\models\ar\Systems;
use app\models\search\EngineersSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

use function app\helpers\d;

class StationsController extends Controller
{
    private array $services = [];

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
                ShipModulesBehavior::class,
                ShipyardShipsBehavior::class
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id, EngineersSearch $eng_search): string
    {
        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $model = Stations::find()
            ->with(['system', 'economyId1', 'economyId2', 'allegiance'])
            ->where(['stations.id' => (int)$id])
            ->asArray()
            ->one();

        !$model && throw new NotFoundHttpException();
        $this->getStationServices($model['market_id']);
        $engineer = $eng_search->getName((int)$model['system_id'], $model['name']);

        $mat_traders = MaterialTraders::findAll(['station_id' => $id]);
        $model['mat_traders'] = $mat_traders;
        // d($model['mat_traders']);
        return $this->render('details', [
            'model' => $model,
            'pad_size' => $this->landingPadSizes[$model['type']],
            'services' => $this->services,
            'id' => $id,
            'eng_name' => $engineer['name'],
            'eng_id' => (int)$engineer['id'],
            // 'mat_traders' => $mat_traders
         ]);
    }

    /**
     * @param int $id
     * @param ShipyardShips $ships
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionShips(int $id, ShipyardShips $ships): string
    {
        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();

        $ships->setShipsArr($this->getShipsList());
        $this->getStationServices($station->market_id);
        $req = new Request();

        return $this->render('ships', [
            'models' => $ships->getStationShips($station->market_id),
            'station_name' => $station->name,
            'id' => $id,
            'services' => $this->services
         ]);
    }

    /**
     * @param int $id
     * @param ShipMods $ship_modules
     * @param string $cat
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionShipModules(int $id, ShipMods $ship_modules, string $cat): string
    {
        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();

        $ship_modules->setMods($this->getShipModules());
        $qty_by_cat = $ship_modules->getQtyByCat($station->market_id);
        $this->getStationServices($station->market_id);

        return $this->render('outfitting', [
            'models' => $ship_modules->getStationModules($station->market_id, $cat),
            'station_name' => $station->name,
            'cat' => $cat,
            'id' => $id,
            'qty_by_cat' => $qty_by_cat,
            'services' => $this->services
         ]);
    }

    /**
     * @param int $id
     * @param StationMarket $market
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionMarket(int $id, StationMarket $market): string
    {
        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();
        $system = Systems::findOne($station->system_id);
        $this->getStationServices($station->market_id);
        $model = $market->getMarket($station->market_id);

        foreach ($model as $key => $value) {
            $model[$key]['req_url'] = ArrayHelper::merge(
                ['commodities/index'],
                $this->getCommoditiesReqArr([
                    'commodity' => [$value['name']],
                    'system' => $system->name,
                    'price_type' => $value['stock'] > 0 ? 'buy' : 'sell'
                ])
            );
        };

        // d($model);

        return $this->render('market', [
            'model' => $model,
            'station_name' => $station->name,
            'id' => $id,
            'services' => $this->services,
         ]);
    }

    /**
     * @param int $market_id
     *
     * @return void
     */
    private function getStationServices(int $market_id): void
    {
        $this->services['market'] = Markets::find()
            ->where(['market_id' => $market_id])
            ->asArray()
            ->count();

        $this->services['modules'] = ShipModules::find()
            ->where(['market_id' => $market_id])
            ->asArray()
            ->count();

        $this->services['ships'] = Shipyard::find()
            ->where(['market_id' => $market_id])
            ->asArray()
            ->count();
    }

    /**
     * @param string $sys_st
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function actionSystemStation(string $sys_st): void
    {
        if (!$sys_st) {
            throw new NotFoundHttpException();
        } else {
            $data = Stations::find()
                ->select('systems.name as system, stations.name as station')
                ->innerJoin('systems', 'stations.system_id = systems.id')
                ->where(['like', 'stations.name', "$sys_st%", false])
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
