<?php

use app\widgets\InputDropdown\InputDropdown;
use yii\grid\GridView;
use yii\helpers\Html;

use function app\helpers\d;

$this->title = 'Search for stations';
$this->params['breadcrumbs'] = [$this->title];
// $this->registerJs("console.log('test')");

// isset($get) && d($get);
// d($refSysDist);
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                    <div class="mt-tr-ref-idd d-flex justify-content-end">
                        <?= Html::beginForm(['/stations/index'], 'get', [
                            'id' => 'mt-form',
                            'class' => 'bg-light p-1 rounded-2',
                            'novalidate' => true,
                        ]) ?>
                        <div class="row gx-2">
                            <div class="col-6" style='max-width: 160px;'>
                                <?= Html::label(
                                    'Max. distance (LY):',
                                    'maxDistance',
                                    ['class' => 'min-lett-spacing fw-bold']
                                ); ?>
                                <div class="search-selected info bg-info px-1 py-1 lh-1 rounded-2">
                                    <?= $form['max_distance']; ?>
                                </div>
                                <?= Html::textInput(
                                    'maxDistance',
                                    '',
                                    [
                                        'id' => 'maxDistance',
                                        'class' => 'form-control shadow-none border border-dark rounded-2 p-1',
                                        'style' => 'min-width: 140px;max-width: 160px;margin-top:0.125rem;'
                                    ]
                                ); ?>
                            </div>
                            <div class="grid-view__ref-sys-divider bg-dark p-0 opacity-50"
                                style="width:2px;max-height:100%"></div>
                            <div class="col-6" style='min-width: 240px;max-width: 240px'>
                                <?= InputDropdown::widget([
                                    'container' => 'mt-tr-ref-idd',
                                    'selected' => $form['system'],
                                    'search' => 'ref-idd-search',
                                    'to_submit' => 'ref-to-submit',
                                    'placeholder' => 'Enter system',
                                    'ajax' => true,
                                    'endpoint' => '/system/get/',
                                    'label_main' => 'Ref. system:',
                                    'toggle_btn_text' => 'Search',
                                    'name_main' => 'refSysStation',
                                    'required' => 'required',
                                    'btn_position' => 'right'
                                ]); ?>
                            </div>
                        </div>
                        <button class="btn btn-violet btn-sm mt-2 lett-spacing-2">submit</button>
                        <?php echo Html::endForm() ?>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'headerRowOptions' => [
                            'class' => 'text-nowrap'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'station', 'label' => 'Station',
                            // 'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                                // 'filterInputOptions' => [
                                //     'class' => 'form-select',
                                // ]
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm',
                                ]
                            ],
                            [
                                'attribute' => 'type',
                                'label' => 'Type',
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm',
                                ]
                            ],
                            [
                                'attribute' => 'distance_to_arrival',
                                'label' => 'Dist. from star (ls)',
                            ],
                            [
                                'attribute' => 'distance',
                                'label' => 'Distance (LY)',
                                'value' => function ($model) {
                                    return (float)$model->distance;
                                }
                            ],
                            ['attribute' => 'government', 'label' => 'Government'],
                            ['attribute' => 'economy_name', 'label' => 'Economy (main)'],
                            ['attribute' => 'allegiance', 'label' => 'Allegiance'],
                            [
                                'attribute' => 'system',
                                'label' => 'System',
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm',
                                ]
                            ],

                            // [
                            //     'attribute' => 'system.name',
                            //     'label' => 'System',
                            //     'value' => function ($model) {
                            //         return Html::a(
                            //             Html::encode($model->system->name),
                            //             Url::toRoute(["system/{$model->system->id}"]),
                            //             ['class' => [
                            //                 'text-decoration-underline',
                            //                 'link-underline-primary',
                            //                 'table-link'
                            //                 ]
                            //             ]
                            //         );
                            //     },
                            //     'format' => 'raw'
                            // ],
                        ],
                        'pager' => [
                            'class' => 'yii\bootstrap5\LinkPager',
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'prevPageCssClass' => 'prev-page',
                            'nextPageCssClass' => 'next-page',
                            'options' => [
                                'class' => 'd-flex justify-content-center'
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>
