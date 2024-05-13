<?php

namespace app\controllers;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use app\models\Markets;
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
                CommoditiesBehavior::class
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
        $model = Stations::find()
            ->select([
                'market_id',
                'system_id',
                'type',
                'distance_to_arrival',
                'government',
                'stations.name AS station_name',
                'sys.name AS system_name'
            ])
            ->innerJoin(['sys' => 'systems'], 'system_id = sys.id')
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
    public function actionMarket(int $id): string
    {
        $id = (int)$id;

        $model = Markets::find()
            ->with('station')
            ->where(['and', "markets.market_id=$id", ['or', 'stock>0', 'demand>0']])
            ->asArray()
            ->all();

        $station_name = $model[0]['station']['name'];

        foreach ($model as $key => $value) {
            $model[$key]['name'] = isset($this->commodities[strtolower($value['name'])]) ?
                $this->commodities[strtolower($value['name'])] : $model[$key]['name'];
            $model[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($model[$key]['timestamp']);
            unset($model[$key]['station']);
            unset($model[$key]['market_id']);
        }

        return $this->render('market', [
            'model' => $model,
            'station_name' => $station_name,
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
