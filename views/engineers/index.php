<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\d;

/** @var array $model */
/** @var app\models\search\EngineersSearch $searchModel */
/** @var yii\data\ArrayDataProvider $dataProvider */
/** @var View $this */

$this->title = 'Engineers';
$this->params['breadcrumbs'] = [$this->title];
// d($queryParams);
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='engineers-cnt col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
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
                                    'class' => 'form-select form-select-sm',
                                    'id' => null
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
                                'format' => 'raw',
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm'
                                ],
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='engineerssearch-name'
                                            name='EngineersSearch[name]'
                                            value='{$queryParams['EngineersSearch']['name']}'>
                                        <button class='btn btn-secondary text-light'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' 
                                                fill='currentColor' class='bi bi-funnel' viewBox='0 0 16 16'>
                                                <path d='M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 
                                                    1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 
                                                    14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 
                                                    4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 
                                                    3.308V2z'/>
                                            </svg>
                                        </button>
                                    </div>
                                ",
                            ],
                            [
                                'attribute' => 'system',
                                'label' => 'System',
                                'value' => function ($model) {
                                    $id = (int)$model['system_id'];
                                    return Html::a(
                                        Html::encode($model['system']),
                                        Url::toRoute(["system/$id"])
                                    );
                                },
                                'format' => 'raw',
                                // 'filterInputOptions' => [
                                //     'class' => 'form-control form-control-sm'
                                // ]
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='engineerssearch-system'
                                            name='EngineersSearch[system]'
                                            value='{$queryParams['EngineersSearch']['system']}'>
                                        <button class='btn btn-secondary text-light'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' 
                                                fill='currentColor' class='bi bi-funnel' viewBox='0 0 16 16'>
                                                <path d='M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 
                                                    1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 
                                                    14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 
                                                    4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 
                                                    3.308V2z'/>
                                            </svg>
                                        </button>
                                    </div>
                                ",
                            ],
                            [
                                'attribute' => 'station',
                                'label' => 'Station',
                                'value' => function ($model) {
                                    $id = (int)$model['station_id'];
                                    return Html::a(
                                        Html::encode($model['station']),
                                        Url::toRoute(["station/$id"])
                                    );
                                },
                                'format' => 'raw',
                                // 'filterInputOptions' => [
                                //     'class' => 'form-control form-control-sm'
                                // ]
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='engineerssearch-station'
                                            name='EngineersSearch[station]'
                                            value='{$queryParams['EngineersSearch']['station']}'>
                                        <button class='btn btn-secondary text-light'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' 
                                                fill='currentColor' class='bi bi-funnel' viewBox='0 0 16 16'>
                                                <path d='M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 
                                                    1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 
                                                    14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 
                                                    4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 
                                                    3.308V2z'/>
                                            </svg>
                                        </button>
                                    </div>
                                ",
                            ],
                            [
                                'attribute' => 'upgrades',
                                'value' => function ($model) {
                                    return implode(", ", $model['upgrades']);
                                },
                                // 'filterInputOptions' => [
                                //     'class' => 'form-control form-control-sm'
                                // ]
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='engineerssearch-upgrades'
                                            name='EngineersSearch[upgrades]'
                                            value='{$queryParams['EngineersSearch']['upgrades']}'>
                                        <button class='btn btn-secondary text-light'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' 
                                                fill='currentColor' class='bi bi-funnel' viewBox='0 0 16 16'>
                                                <path d='M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 
                                                    1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 
                                                    14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 
                                                    4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 
                                                    3.308V2z'/>
                                            </svg>
                                        </button>
                                    </div>
                                ",
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