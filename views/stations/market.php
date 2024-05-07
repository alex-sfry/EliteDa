<?php

use app\widgets\Table\Table;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = $station_name;
?>

<div class="bg-light">
    <?php /* VarDumper::dump($model, 10, true); */ ?>
</div>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <?php echo Table::widget([
        'container' => 'c-table',
        'model' => $model,
        'columns' => [
            [
                'attribute' => 'buy_price',
                'label' => 'buy price',
            ],
            [
                'attribute' => 'demand',
            ],
            [
                'attribute' => 'demand_bracket',
                'label' => 'demand bracket',
                'filter' => ['0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                'filterInputOptions' => [
                    'class' => 'form-select',
                ],
            ],
            [
                'attribute' => 'mean_price',
                'label' => 'mean price',
            ],
            [
                'attribute' => 'name',
                'label' => 'commodity',
                'filterInputOptions' => [
                    'class' => 'form-control',
                ]
            ],
            [
                'attribute' => 'sell_price',
                'label' => 'sell price',
            ],
            [
                'attribute' => 'stock',
            ],
            [
                'attribute' => 'stock_bracket',
                'label' => 'stock bracket',
                'filter' => ['0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                'filterInputOptions' => [
                    'class' => 'form-select',
                ],
            ],
        ]
    ]); ?>
</main>