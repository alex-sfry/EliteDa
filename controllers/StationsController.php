<?php

namespace app\controllers;

use app\behaviors\ShipModulesBehavior;
use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\StationBehavior;
use app\models\ar\Markets;
use app\models\ar\MaterialTraders;
use app\models\ar\ShipModules;
use app\models\ar\Shipyard;
use app\models\ar\Stations;
use app\models\ar\Systems;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use function app\helpers\d;

class StationsController extends Controller
{
    private array $services = [];

    public function actionIndex(\app\models\search\StationsInfoSearch $searchModel): string
    {
        $session = Yii::$app->session;
        $session->open();
        // $session->destroy();
        $request = Yii::$app->request;

        if (count($request->get()) > 0) {
            $get = $request->get();

            if (isset($request->get()['refSysStation']) && isset($request->get()['maxDistance'])) {
                !$session->get('st') && $session->set('st', $request->get());

                switch ($get['refSysStation']) {
                    case '':
                        $get['refSysStation'] = $session->get('st')['refSysStation'] !== '' ?
                            $session->get('st')['refSysStation'] : 'Sol';
                        break;
                    default:
                        break;
                }

                switch ($get['maxDistance']) {
                    case '':
                        $get['maxDistance'] = $session->get('st')['maxDistance'] !== '' ?
                            $session->get('st')['maxDistance'] : 50;
                        break;
                    default:
                        break;
                }

                $session->set('st', $get);
            }
        }

        if (isset($session->get('st')['refSysStation']) || isset($session->get('st')['maxDistance'])) {
            if ($session->get('st')['refSysStation'] !== '' || $session->get('st')['maxDistance'] !== '') {
                $system = $session->get('st')['refSysStation'];
                $maxDistance = (int)$session->get('st')['maxDistance'];
                $system = !$system ? 'Sol' : $system;
                $maxDistance = $maxDistance === 0 ? 1 : $maxDistance;
                $system = $session->get('st')['refSysStation'];
            }
        }

        if (!isset($system)) {
            $system = 'Sol';
        }
        if (!isset($maxDistance)) {
            $maxDistance = 50;
        }

        $params['form'] = [
            'system' => $system,
            'max_distance' => $maxDistance
        ];

        $dataProvider = $searchModel->search($this->request->queryParams, $maxDistance, $system);
        $dataProvider->pagination = ['pageSize' => 50];

        $dataProvider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        if (empty($this->request->queryParams) || !isset($this->request->queryParams['StationsInfoSearch'])) {
            $params['queryParams']['StationsInfoSearch'] = array_fill_keys(
                array_values($searchModel->activeAttributes()),
                null
            );
        } else {
            $params['queryParams'] = $this->request->queryParams;
        }

        $params['dataProvider'] = $dataProvider;
        $params['searchModel'] = $searchModel;

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidArgumentException
     */
    public function actionDetails(int $id, \app\models\search\EngineersSearch $eng_search): string
    {
        /** @var StationBehavior|StationsController $this */

        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $this->attachBehavior('StationBehavior', StationBehavior::class);

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

        return $this->render('details', [
            'model' => $model,
            'pad_size' => $this->getLandingPadSizes()[$model['type']],
            'services' => $this->services,
            'id' => $id,
            'eng_name' => $engineer['name'],
            'eng_id' => (int)$engineer['id'],
         ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidArgumentException
     */
    public function actionShips(int $id, \app\models\ShipyardShips $ships): string
    {
        /** @var ShipyardShipsBehavior|StationsController $this */

        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $this->attachBehavior('ShipyardShipsBehavior', ShipyardShipsBehavior::class);

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();

        $ships->setShipsArr($this->getShipsList());
        $this->getStationServices($station->market_id);
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();
        $model = $ships->getStationShips($station->market_id, $system->name);

        return $this->render('ships', [
            'models' => $model,
            'station_name' => $station->name,
            'id' => $id,
            'services' => $this->services
         ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidArgumentException
     */
    public function actionShipModules(int $id, \app\models\ShipMods $ship_modules, string $cat): string
    {
        /** @var ShipModulesBehavior|StationsController $this */

        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $this->attachBehavior('ShipModulesBehavior', ShipModulesBehavior::class);

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();

        $ship_modules->setMods($this->getShipModules());
        $qty_by_cat = $ship_modules->getQtyByCat($station->market_id);
        $this->getStationServices($station->market_id);
        $model = $ship_modules->getStationModules($station->market_id, $cat, $system->name);

        return $this->render('outfitting', [
            'models' => $model,
            'station_name' => $station->name,
            'cat' => $cat,
            'id' => $id,
            'qty_by_cat' => $qty_by_cat,
            'services' => $this->services
         ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidArgumentException
     */
    public function actionMarket(int $id, \app\models\StationMarket $market): string
    {
        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();
        $this->getStationServices($station->market_id);
        $model = $market->getMarket($station->market_id, $system->name);

        return $this->render('market', [
            'model' => $model,
            'station_name' => $station->name,
            'id' => $id,
            'services' => $this->services,
         ]);
    }

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
