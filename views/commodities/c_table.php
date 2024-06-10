<?php

use app\widgets\alext\BootstrapTable\BootstrapTable;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

use function app\helpers\d;

/**
 * @var array $models
 * @var string $buy_sell_switch
 * @var Pagination|false $pagination
 * @var Sort $sort
 * @var View $this
 */

//  d($models[0]);
?>
<div class="c-result-legend bg-light text-center mt-3 rounded-2 py-1">
    <h2 class="fs-6 position-relative">Station's type:</h2>
    <div class="d-flex align-items-center py-1 ps-2 pe-1">
        <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 pe-1 align-items-center">
            <div class="c-result-legend-item-color bg-success h-100"></div>
            - surface
        </div>
        <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 align-items-center">
            <div class="c-result-legend-item-color bg-primary ms-2 h-100"></div>
            - space
        </div>
    </div>
</div>

<?php echo BootstrapTable::widget([
    'models' => $models,
    'columns' => [
        ['attribute' => 'commodity', 'label' => 'Commodity'],
        [
            'attribute' => 'station',
            'label' => 'Station',
            'value' => function ($model) {
                $station_id = (int)$model['station_id'];
                return Html::a(
                    $model['station']['text'],
                    Url::toRoute(["station/$station_id"]),
                    ['class' => 'text-decoration-underline link-underline-primary table-link']
                );
            },
        ],
        [
            'attribute' => 'type',
            'label' => 'Type',
            'class' => function ($model) {
                $cls = $model['surface'] ? 'text-success' : 'text-primary';
                return 'sintony-bold ' . $cls;
            }
        ],
        ['attribute' => 'pad', 'label' => 'Pad'],
        [
            'attribute' => 'system',
            'label' => 'System',
            'value' => function ($model) {
                $system_id = (int)$model['system_id'];
                return Html::a(
                    $model['system']['text'],
                    Url::toRoute(["system/$system_id"]),
                    ['class' => 'text-decoration-underline link-underline-primary table-link']
                );
            },
        ],
        ['attribute' => 'distance_ly', 'label' => 'Dist.(LY)', 'sortable' => true],
        ['attribute' => 'distance_ls', 'label' => 'Dist. to arr.(ls)'],
        [
            'attribute' => $buy_sell_switch === 'buy' ? 'stock' : 'demand',
            'label' => $buy_sell_switch === 'buy' ? 'Supply' : 'Demand'
        ],
        [
            'attribute' => $buy_sell_switch === 'buy' ? 'buy_price' : 'sell_price',
            'label' => 'Price',
            'value' => function ($model) {
                d($model);
                return isset($model['sell_price']) ? $model['sell_price'] : $model['buy_price'];
            },
            'sortable' => true,
            'class' => 'text-success'
        ],
        ['attribute' => 'time_diff', 'label' => 'Updated', 'sortable' => true],
    ],
    'pagination' => $pagination,
    'sort' => $sort
]);
