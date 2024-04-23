<?php

namespace app\commands;

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
    public function actionArray(string $csv = ''): int
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
        $start_memory = round((memory_get_usage() / 1024));

        if (!$csv) {
            echo 'Provide path to csv file' . "\n";
            return ExitCode::OK;
        }

        $this->actionArray($csv);
        $ship_modules_arr = [];

        foreach ($this->csv_arr as $item) {
            $ship_modules_arr[$item['symbol']] = "{$item['class']}{$item['rating']} {$item['name']}";

            if ($item['mount']) {
                $ship_modules_arr[$item['symbol']] .= " [{$item['mount']}]";
            }
        }

        file_put_contents(
            Yii::getAlias('@app/data/shipModules.json'),
            Json::encode($ship_modules_arr, JSON_PRETTY_PRINT)
        );

        $batch_rows = array_map(function ($item) {
            return array_values($item);
        }, $this->csv_arr);

        // VarDumper::dump($batch_rows);

        Yii::$app->db->createCommand()
            ->batchInsert('ship_modules', [
                'id', 'symbol', 'category', 'name', 'mount', 'guidance', 'ship', 'class', 'rating', 'entitlement'
            ], $batch_rows)
            ->execute();

        echo "\n" . $start_memory . "\n";
        echo round((memory_get_usage() / 1024)) . "\n";
        echo  "\n" . round((memory_get_peak_usage() / 1024));

        return ExitCode::OK;
    }
}
