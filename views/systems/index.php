<?php

use app\widgets\InputDropdown\InputDropdown;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

use function app\helpers\d;

/** @var app\models\ar\Systems $model */
/** @var app\models\search\SystemsInfoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var View $this */

$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, systems';
$this->title = 'Search for systems';
$this->params['breadcrumbs'] = [$this->title];

$allegiance_options = [
    'Alliance' => 'Alliance',
    'Empire' => 'Empire',
    'Federation' => 'Federation',
    'Independent' => 'Independent',
    'None' => 'None',
    'Pirate' => 'Pirate',
    'unknown' => 'unknown'
];

$economy_options = [
    'Agriculture' => 'Agriculture',
    'Colony' => 'Colony',
    'Damaged' => 'Damaged',
    'Extraction' => 'Extraction',
    'High Tech' => 'High Tech',
    'Industrial' => 'Industrial',
    'Military' => 'Military',
    'None' => 'None',
    'Prison' => 'Prison',
    'Private Enterprise' => 'Private Enterprise',
    'Refinery' => 'Refinery',
    'Repair' => 'Repair',
    'Rescue' => 'Rescue',
    'Service' => 'Service',
    'Terraforming' => 'Terraforming',
    'Tourism' => 'Tourism',
    'Engineering' => 'Engineering',
    'unknown' => 'unknown'
];

$security_options = [
    'Anarchy' => 'Anarchy',
    'Lawless' => 'Lawless',
    'Low' => 'Low',
    'Medium' => 'Anarchy',
    'High' => 'High',
    'unknown' => 'unknown',
];

$population_options = [
    '10000000' => '>= 10Mil',
    '100000000' => '>= 100Mil',
    '1000000000' => '>= 1Bil',
    '10000000000' => '>= 10Bil',
    '20000000000' => '>= 20Bil',
];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg fs-7">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                    <div class="mt-tr-ref-idd d-flex justify-content-end gap-2 flex-column flex-sm-row">
                        <?= Html::beginForm(
                            [Url::to(ArrayHelper::merge(['/systems/index'], $queryParams))],
                            'get',
                            ['id' => 'mt-form', 'class' => 'bg-light p-1 rounded-2', 'novalidate' => true]
                        ) ?>
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
                            'class' => 'text-nowrap align-middle'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'system',
                                'value' => function ($model) {
                                    $id = (int)$model->id;
                                    return Html::a(
                                        Html::encode($model->system),
                                        Url::toRoute(["system/$id"]),
                                        ['class' => [
                                            'text-decoration-underline',
                                            'link-underline-primary',
                                            'table-link'
                                            ]
                                        ]
                                    );
                                },
                                'format' => 'raw',
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='systemsinfosearch-system'
                                            name='SystemsInfoSearch[system]'
                                            value='{$queryParams['SystemsInfoSearch']['system']}'>
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
                                'attribute' => 'distance',
                            ],
                            [
                                'attribute' => 'population',
                                'filter' => $population_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ],
                                'format' => 'integer'
                            ],
                            [
                                'attribute' => 'security',
                                'filter' => $security_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'economy',
                                'filter' => $economy_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'allegiance',
                                'filter' => $allegiance_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
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
