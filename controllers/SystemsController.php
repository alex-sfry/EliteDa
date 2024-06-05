<?php

namespace app\controllers;

use app\models\ar\Systems;
use app\models\search\SystemsInfoSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use function app\helpers\d;

class SystemsController extends Controller
{
    public function actionIndex(): string
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

        $searchModel = new SystemsInfoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $maxDistance, $system);
        $dataProvider->pagination = ['pageSize' => 50];

        $dataProvider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        if (empty($this->request->queryParams) || !isset($this->request->queryParams['SystemsInfoSearch'])) {
            $params['queryParams']['SystemsInfoSearch'] = array_fill_keys(
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
     */
    public function actionDetails(int $id): string
    {
        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $model = Systems::find()
            ->with(['stations', 'economy', 'security', 'allegiance'])
            ->where(['systems.id' => (int)$id])
            ->asArray()
            ->one();

        !$model && throw new NotFoundHttpException();

        return $this->render('details', [
            'model' => ArrayHelper::htmlEncode($model)
         ]);
    }

    public function actionSystem(string $sys): void
    {
        if (!$sys) {
            throw new NotFoundHttpException();
        } else {
            $data = Systems::find()
                ->select('name as system')
                ->where(['like', 'name', "$sys%", false])
                ->orderBy('name')
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ArrayHelper::htmlEncode($data);

            $response->send();
        }
    }
}
