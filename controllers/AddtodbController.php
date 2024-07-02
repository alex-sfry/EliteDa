<?php

namespace app\controllers;

use DiDom\Document;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class AddtodbController extends Controller
{
    /**
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if ($action->id === 'materials') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex(): string
    {
        if (!Yii::$app->user->can('accessAddtodb')) {
            if (Yii::$app->request->isPost) {
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;
                $response->statusCode = 403;
                $response->data =  ['error' => 'access denied'];
                $response->send();

//                throw new \yii\web\NotFoundHttpException;
            } else {
                return 'access denied';
            }
        }

        $params = [];

        return $this->render('index', $params);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionMaterials(): string|bool
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return 'Only POST requests are accepted';
        }
        if (
            !ArrayHelper::keyExists('grade', $request->post()[0], false) &&
            !ArrayHelper::keyExists('location', $request->post()[0], false)
        ) {
            return 'Incorrect request body(keys)';
        }
        if (!count($request->post()[0]) > 0 || count($request->post()[0]) !== 5) {
            return 'Incorrect request body(length)';
        }

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $request->post());

        Yii::$app->db->createCommand()
            ->batchInsert('materials', ['name', 'category', 'grade', 'type', 'location'], $batch_rows)
            ->execute();

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $request->post();
        $response->send();

        return true;
    }

    /**
     * @throws \DiDom\Exceptions\InvalidSelectorException
     */
    public function actionEngineers(): string
    {
        $document = new Document('https://elite-dangerous.fandom.com/wiki/Engineers', true);
        $engineers_table = $document->find('table:nth-of-type(1) tbody tr');
        array_splice($engineers_table, 26);
        $engineers_summary_table = $document->find('table:nth-of-type(5) tbody tr');
        $engineers_ship = $this->parseEngineersTable($engineers_table, $engineers_summary_table, 'ship');
        $engineers_table = $document->find('table:nth-of-type(2) tbody tr');
        $engineers_summary_table = $document->find('table:nth-of-type(6) tbody tr');
        $engineers_pilot = $this->parseEngineersTable($engineers_table, $engineers_summary_table, 'pilot');
        $params['engineers'] = ArrayHelper::merge($engineers_ship, $engineers_pilot);

        file_put_contents(Yii::getAlias('@app/data/engineers.json'), Json::encode($params['engineers']));

        return $this->render('engineers', $params);
    }

    protected function parseEngineersTable(array $table, array $sum_table, string $target): array
    {
        $arr = [];
        $arr2 = [];

        foreach ($table as $item) {
            $tds = $item->find('td');
            $inner_arr = [];

            foreach ($tds as $key => $value) {
                switch ($key) {
                    case 0:
                        $inner_arr['name'] = trim($value->text());
                        break;
                    case 1:
                        $inner_arr['station'] = trim($value->text());
                        break;
                    case 2:
                        $inner_arr['upgrades'] =
                            StringHelper::explode(str_replace(["\n", "(", ")"], [",", "", ""], trim($value->text())));
                        break;
                    case 3:
                        $inner_arr['system'] = trim($value->text());
                        break;
                }

                $inner_arr['target'] = $target;
            }

            $arr[] = $inner_arr;
        }

        array_shift($arr);

        foreach ($sum_table as $key => $item) {
            $tds = $item->find('td');
            $inner_arr = [];

            foreach ($tds as $key2 => $value) {
                switch ($key2) {
                    case 0:
                        $inner_arr['name2'] = trim($value->text());
                        break;
                    case 3:
                        $inner_arr['discovery'] = trim($value->text());
                        break;
                    case 4:
                        $inner_arr['get_invite'] = trim($value->text());
                        break;
                    case 5:
                        $inner_arr['unlock'] = trim($value->text());
                        break;
                    case 6:
                        $inner_arr['gain_rep'] = trim($value->text());
                        break;
                }
            }

            $arr2[] = $inner_arr;
        }

        array_shift($arr2);

        foreach ($arr as $key => $value) {
            foreach ($arr2 as $item) {
                if ($value['name'] === $item['name2']) {
                    $arr[$key] = ArrayHelper::merge($value, $item);
                }
            }
        }

        return $arr;
    }
}
