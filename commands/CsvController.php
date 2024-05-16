<?php

namespace app\commands;

use app\models\Commodities;
use app\models\ShipsList;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class CsvController extends Controller
{
    private array $csv_arr = [];

    /**
     * @param string $message the message to be echoed.
     *
     * @return int Exit code
     */
    public function actionIndex(string $message = 'hello world'): int
    {
        // echo $message . "\n";

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
     * @param string $csv path to csv file.
     *
     * @return int Exit code
     */
    public function createArrayFromCsv(string $csv = ''): int
    {
        if (!$csv) {
            echo 'Provide path to csv file' . "\n";
            return ExitCode::OK;
        }

        $rows = array_map('str_getcsv', file(Yii::getAlias("@app/$csv")));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $this->csv_arr[] = array_combine($header, $row);
        }

        return ExitCode::OK;
    }

    /**
     * @param string $csv path to csv file.
     *
     * @return int Exit code
     */
    public function actionOutfitting(string $csv = ''): int
    {
        if (!$csv) {
            echo 'Provide path to csv file' . "\n";
            return ExitCode::OK;
        }

        $ship_names = ShipsList::find()
        ->asArray()
        ->all();

        $symbols = [];
        $ships_symb_names = [];

        foreach ($ship_names as $key => $value) {
            $symbols[] = $value['symbol'];
            $ships_symb_names[$value['symbol']] = $value['name'];
        }

        $this->createArrayFromCsv($csv);
        $ship_modules_arr = [];

        foreach ($this->csv_arr as &$item) {
            foreach ($symbols as $symbol) {
                if (str_starts_with(strtolower($item['symbol']), $symbol)) {
                    $item['symbol'] = str_ireplace($symbol, $symbol, $item['symbol']);
                }
            }

            $ship_modules_arr[$item['symbol']] = "{$item['class']}{$item['rating']} {$item['name']}";

            if ($item['mount']) {
                $ship_modules_arr[$item['symbol']] .= " [{$item['mount']}]";
            }

            foreach ($symbols as $symbol) {
                if (str_starts_with(strtolower($item['symbol']), $symbol)) {
                    if (str_contains($ship_modules_arr[$item['symbol']], ' - ')) {
                        $ship_modules_arr[$item['symbol']] =
                            str_replace(substr(
                                $ship_modules_arr[$item['symbol']],
                                strpos($ship_modules_arr[$item['symbol']], ' - ')
                            ), " - $ships_symb_names[$symbol]", $ship_modules_arr[$item['symbol']]);
                    } else {
                        $ship_modules_arr[$item['symbol']] .= " - $ships_symb_names[$symbol]";
                    }
                }
            }
        }

        file_put_contents(
            Yii::getAlias('@app/data/shipModules.json'),
            Json::encode($ship_modules_arr, JSON_PRETTY_PRINT)
        );

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $this->csv_arr);

        Yii::$app->db->createCommand()
            ->batchInsert('ship_modules_list', [
                'id', 'symbol', 'category', 'name', 'mount', 'guidance', 'ship', 'class', 'rating', 'entitlement'
            ], $batch_rows)
            ->execute();

        return ExitCode::OK;
    }

    /**
     * @param string $csv path to csv file.
     *
     * @return int Exit code
     */
    public function actionShipyard(string $csv = ''): int
    {
        if (!$csv) {
            echo 'Provide path to csv file' . "\n";
            return ExitCode::OK;
        }

        $this->createArrayFromCsv($csv);
        $ships_arr = [];

        foreach ($this->csv_arr as $key => $value) {
            $ships_arr[$value['symbol']] = $value['name'];
            $this->csv_arr[$key]['symbol'] = strtolower($value['symbol']);
        }

        $ships_arr = array_change_key_case($ships_arr);

        file_put_contents(
            Yii::getAlias('@app/data/ships.json'),
            Json::encode($ships_arr, JSON_PRETTY_PRINT)
        );

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $this->csv_arr);

        Yii::$app->db->createCommand()
            ->batchInsert('ships_list', [
                'id', 'symbol', 'name', 'entitlement'
            ], $batch_rows)
            ->execute();

        return ExitCode::OK;
    }

    /**
     * @param string $csv path to csv file.
     *
     * @return int Exit code
     */
    public function actionCommodities(string $csv = ''): int
    {
        if (!$csv) {
            echo 'Provide path to csv file' . "\n";
            return ExitCode::OK;
        }

        $this->createArrayFromCsv($csv);
        $commodities_arr = [];

        foreach ($this->csv_arr as $key => $value) {
            $commodities_arr[strtolower($value['symbol'])] = $value['name'];
        }

        $commodities_arr = array_change_key_case($commodities_arr);

        file_put_contents(
            Yii::getAlias('@app/data/commodities.json'),
            Json::encode($commodities_arr, JSON_PRETTY_PRINT)
        );

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $this->csv_arr);

        $cmd_db_list = Commodities::find()
        ->asArray()
        ->all();

        VarDumper::dump(Json::decode(file_get_contents(Yii::$app->basePath . '/data/commodities.json')));

        Yii::$app->db->createCommand()
        ->batchInsert('commodities', [
            'id', 'symbol', 'category', 'name'
        ], $batch_rows)
        ->execute();

        return ExitCode::OK;
    }
}
