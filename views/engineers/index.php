<?php

/**
 * @var array $engineers
 * @var ArrayDataProvider $dataProvider
 * @var ArrayDataProvider $searchModel
 */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Engineers';
?>

<div class="bg-light">
<!--    --><?php //VarDumper::dump($engineers, 10, true); ?>
</div>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="text-light-orange text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'headerRowOptions' => [
                            'class' => 'engineers-header'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'target',
                                'label' => 'ship / pilot',
                                'filter' => ['ship' => 'ship', 'pilot' => 'pilot'],
                                'filterInputOptions' => [
                                    'class' => 'form-select',
                                ],
                            ],
                            [
                                'attribute' => 'name',
                                'label' => 'Name',
                            ],
                            ['attribute' => 'system', 'label' => 'System'],
                            ['attribute' => 'station', 'label' => 'Station'],
                            [
                                'attribute' => 'upgrades',
                                'value' => function ($model) {
                                    return implode(", ", $model['upgrades']);
                                }
                            ],
                            ['attribute' => 'discovery', 'label' => 'Discovery'],
                        ],
                        'pager' => [
                            'class' => 'yii\bootstrap5\LinkPager',
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'prevPageCssClass' => 'prev-page',
                            'nextPageCssClass' => 'next-page'
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>