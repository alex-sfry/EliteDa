<?php

/**
 * @var array $engineers
 * @var ArrayDataProvider $dataProvider
 * @var ArrayDataProvider $searchModel
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = 'Engineers';
$this->params['breadcrumbs'] = [$this->title];
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='engineers-cnt col'>
                    <h1 class="mt-2 text-custom-orange text-center sintony-bold"><?= $this->title ?></h1>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'headerRowOptions' => [
                            'class' => 'engineers-header'
                        ],
                        'rowOptions' => [
                            'class' => 'engineers-body-row'
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
                                'value' => function ($model) {
                                    $id = (int)$model['id'];
                                    return Html::a(
                                        Html::encode($model['name']),
                                        Url::toRoute(["engineer/$id"])
                                    );
                                },
                                'format' => 'raw'
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