<?php

namespace app\controllers;

use app\behaviors\ShipModulesBehavior;
use app\behaviors\ShipyardShipsBehavior;
use app\behaviors\StationBehavior;
use app\models\ar\MaterialTraders;
use app\models\ar\Stations;
use app\models\ar\Systems;
use app\models\forms\StationsAdvancedForm;
use app\models\forms\StationsNameForm;
use app\models\search\EngineersSearch;
use app\models\ShipMods;
use app\models\ShipyardShips;
use app\models\StationMarket;
use app\services\StationsService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use function app\helpers\d;

class StationsController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = $this->request;
        $session->open();
        // $session->destroy();
        $by_name_form = new StationsNameForm();
        $params['by_name_form'] = $by_name_form;
        $adv_form = new StationsAdvancedForm();
        $params['adv_form'] = $adv_form;
        // d($request->get());
        if (array_key_exists('stNameBtn', $request->get())) {
            $session->set('st_name', $request->get());

            if ($by_name_form->load($session->get('st_name'), '') && $by_name_form->validate()) {
                $service = new StationsService($by_name_form->attributes);
                $models = $service->findStationsByName()->limit(100)->asArray()->cache(86400)->all();
            }
        }

        if (array_key_exists('advFormBtn', $request->get())) {
            $session->set('st_adv_form', $request->get());
            $adv_form->load($session->get('st_adv_form'), '');

            if ($adv_form->load($session->get('st_adv_form'), '') && $adv_form->validate()) {
                $service = new StationsService($adv_form->attributes);
                $models = $service->findStations()->orderBy('distance')->limit(100)->asArray()->cache(86400)->all();
            }
        }

        $params['by_name_form_values'] = $session->get('st_name') ?? $by_name_form->attributes;
        $params['adv_form_values'] = $session->get('st_adv_form') ?? $adv_form->attributes;

        if (isset($models) && !empty([$models])) {
            $params['models'] = $models;
        }

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id): string
    {
        /** @var StationBehavior|StationsController $this */

        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $this->attachBehavior('StationBehavior', StationBehavior::class);

        $model = Stations::find()
            ->with(['system', 'economyId1', 'economyId2', 'allegiance'])
            ->where(['stations.id' => (int)$id])
            ->cache(86400)
            ->asArray()
            ->one();

        !$model && throw new NotFoundHttpException();
        $service = new StationsService();
        $services = $service->getStationServices($model['market_id']);

        $eng_search = new EngineersSearch();
        $engineer = $eng_search->getName((int)$model['system_id'], $model['name']);
        $mat_traders = MaterialTraders::findAll(['station_id' => $id]);
        $model['mat_traders'] = $mat_traders;

        return $this->render('details', [
            'model' => $model,
            'pad_size' => $this->getLandingPadSizes()[$model['type']],
            'services' => $services,
            'id' => $id,
            'eng_name' => $engineer['name'],
            'eng_id' => (int)$engineer['id'],
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionShips(int $id): string
    {
        /** @var ShipyardShipsBehavior|StationsController $this */

        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $this->attachBehavior('ShipyardShipsBehavior', ShipyardShipsBehavior::class);
        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();

        $ships = new ShipyardShips();
        $ships->setShipsArr($this->getShipsList());
        $service = new StationsService();
        $services = $service->getStationServices($station->market_id);
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();

        $ships->setAttributes(['market_id' => $station->market_id, 'sys_name' => $system->name], false);
        $model = $ships->getStationShips();

        return $this->render('ships', [
            'models' => $model,
            'station_name' => $station->name,
            'id' => $id,
            'services' => $services
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionShipModules(int $id, string $cat): string
    {
        /** @var ShipModulesBehavior|StationsController $this */

        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $this->attachBehavior('ShipModulesBehavior', ShipModulesBehavior::class);
        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();

        $ship_modules = new ShipMods();
        $ship_modules->setMods($this->getShipModules());
        $ship_modules->setAttributes(
            ['market_id' => $station->market_id, 'cat' => $cat, 'sys_name' => $system->name],
            false
        );
        $qty_by_cat = $ship_modules->getQtyByCat();
        $service = new StationsService();
        $services = $service->getStationServices($station->market_id);
        $model = $ship_modules->getStationModules();

        return $this->render('outfitting', [
            'models' => $model,
            'station_name' => $station->name,
            'cat' => $cat,
            'id' => $id,
            'qty_by_cat' => $qty_by_cat,
            'services' => $services
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionMarket(int $id): string
    {
        !$id && throw new NotFoundHttpException();
        $id = (int)$id;

        $station = Stations::findOne($id);
        !$station && throw new NotFoundHttpException();
        $system = Systems::findOne($station->system_id);
        !$system && throw new NotFoundHttpException();
        $service = new StationsService();
        $services = $service->getStationServices($station->market_id);

        $market = new StationMarket();
        $model = $market->findMarket($station->market_id, $system->name);

        return $this->render('market', [
            'model' => $model,
            'station_name' => $station->name,
            'id' => $id,
            'services' => $services,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSystemStation(string $sys_st): void
    {
        if (!$sys_st) {
            throw new NotFoundHttpException();
        } else {
            $data = (new StationsService())->systemStation($sys_st)
                ->select(['systems.name as system', 'stations.name as station'])
                ->orderBy('stations.name')
                ->cache(86400)
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send();
        }
    }
}
