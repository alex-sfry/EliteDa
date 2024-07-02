<?php

namespace app\commands;

use app\models\ar\ShipModulesList;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class JsonController extends Controller
{
    protected array $result = [];

    public function actionIndex(): int
    {
        $all_methods = get_class_methods($this);
        $parent_class_methods = get_class_methods(get_parent_class($this));
        $own_methods = array_diff($all_methods, $parent_class_methods);
        array_shift($own_methods);

        echo 'Available mothods are:' . "\n";

        foreach ($own_methods as $method) {
            echo $method . "\n";
        }

        return ExitCode::OK;
    }

    /**
     * @param string $json path to json file.
     */
    protected function createArrayFromJson(string $json = '')
    {
        if (!$json) {
            echo 'Provide path to json file' . "\n";
            return ExitCode::OK;
        }

        $files = FileHelper::findFiles(Yii::$app->basePath . $json, ['only' => ['*.json']]);

        foreach ($files as $file) {
            $arr = Json::decode(file_get_contents($file));

            if (!isset($arr[array_key_first($arr)]['retailCost'])) {
                $arr = $arr[array_key_first($arr)];

                foreach ($arr as $item) {
                    $this->result[] = [
                        'symbol' => $item['symbol'],
                        'price' => $item['cost']
                    ];
                }
            } else {
                foreach ($arr as $key => $value) {
                    $this->result[] = [
                        'name' => str_replace('Mk ', 'Mk', $value['properties']['name']),
                        'price' => $value['retailCost']
                    ];
                }
            }

            $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));
        }
    }

    /**
     * @param string $json path to json file.
     */
    protected function createArrayFromJsonForCoreInt(string $json = '')
    {
        if (!$json) {
            echo 'Provide path to json file' . "\n";
            return ExitCode::OK;
        }

        $files = FileHelper::findFiles(Yii::$app->basePath . $json, ['only' => ['*.json']]);

        foreach ($files as $file) {
            $arr = Json::decode(file_get_contents($file));

            foreach ($arr as $key => $value) {
                foreach ($value['bulkheads'] as $item) {
                    $this->result[] = [
                    'edID' => $item['edID'],
                    'price' => $item['cost']
                    ];
                }
            }
        }

        $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));
    }

    /**
     * @param string $json path to json file.
     */
    public function actionModules(string $json = ''): int
    {
        $this->createArrayFromJson($json);

        Yii::$app->db->createCommand()
            ->batchInsert('modules_price_list', ['symbol', 'price'], $this->result)
            ->execute();

        return ExitCode::OK;
    }

    /**
     * @param string $json path to json file.
     */
    public function actionShips(string $json = ''): int
    {
        $this->createArrayFromJson($json);

        Yii::$app->db->createCommand()
            ->batchInsert('ships_price_list', ['name', 'price'], $this->result)
            ->execute();

        return ExitCode::OK;
    }

    /**
     * @param string $json path to json file.
     */
    public function actionShipscore(string $json = ''): int
    {
        $this->createArrayFromJsonForCoreInt($json);

        $edIDs = ArrayHelper::getColumn($this->result, 'edID');

        $res = ShipModulesList::find()
            ->select(['id', 'symbol'])
            ->where(['id' => $edIDs])
            ->indexBy('id')
            ->asArray()
            ->all()
        ;

        foreach ($res as $key => $value) {
            foreach ($this->result as $k => $val) {
                if ($val['edID'] === $key) {
                    $this->result[$k]['symbol'] = $value['symbol'];
                }
            }
        }

        foreach ($this->result as $key => $value) {
            unset($this->result[$key]['edID']);

            if (!isset($this->result[$key]['symbol'])) {
                unset($this->result[$key]);
            }
        }

        // VarDumper::dump($this->result);

        Yii::$app->db->createCommand()
            ->batchInsert('modules_price_list', ['price', 'symbol'], $this->result)
            ->execute();

        return ExitCode::OK;
    }
}
