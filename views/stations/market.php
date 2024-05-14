<?php

use app\widgets\TableJs\TableJs;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = $station_name . ' market';
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row">
            <div class="col mb-3">
                <h1 class='mt-3 text-center fs-2 text-custom-orange sintony-bold'>
                    <?= Html::encode($this->title) ?>
                </h1>
                <?= TableJs::widget([
                    'container' => 'w-table',
                    'model' => $model,
                    'default_sorting' => 'asc',
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
                            'filter' => ['' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                            'filterInputOptions' => [
                                'class' => 'form-select',
                            ],
                            'class' => 'text-center'
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
                            'filter' => ['' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                            'filterInputOptions' => [
                                'class' => 'form-select',
                            ],
                            'class' => 'text-center'
                        ],
                        [
                            'attribute' => 'timestamp',
                            'label' => 'updated',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</main>