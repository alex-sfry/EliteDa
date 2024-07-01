<?php

use app\widgets\InputDropdown\InputDropdown;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use function app\helpers\d;

/**
 * @var MaterialTradersSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->params['meta_keywords'] = 'Elite: Dangerous, rings, mining, pristine rings';
$this->title = 'Rings';
$this->params['breadcrumbs'] = [$this->title];

$dta_options = [
    '500' => '<= 500',
    '1000' => '<= 1000',
    '2000' => '<= 2000',
    '3000' => '<= 3000',
    '4000' => '<= 4000',
];

// d($dataProvider);
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg fs-7">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
                    <div class="mt-tr-ref-idd ms-auto d-flex justify-content-end">
                        <?= Html::beginForm(
                            [Url::to(ArrayHelper::merge(['/rings/index'], $queryParams))],
                            'get',
                            ['id' => 'mt-form', 'class' => 'bg-light p-1 rounded-2', 'novalidate' => true]
                        ) ?>
                        <?= InputDropdown::widget([
                            'container' => 'mt-tr-ref-idd',
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
                        <button class="btn btn-violet btn-sm">submit</button>
                        <?= Html::endForm() ?>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'headerRowOptions' => ['class' => 'white-space-nw'],
                        'rowOptions' => ['class' => 'white-space-nw'],
                        'columns' => [
                            [
                                'attribute' => 'name',
                                'label' => 'Ring name',
                            ],
                            [
                                'attribute' => 'type',
                                'label' => 'Ring type',
                                'filter' => [
                                    'Metal Rich' => 'Metal Rich',
                                    'Icy' => 'Icy',
                                    'Rocky' => 'Rocky',
                                    'Metallic' => 'Metallic',
                                ],
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ],
                            ],
                            [
                                'attribute' => 'reserve',
                                'label' => 'Reserve',
                                'value' => function ($model) {
                                    return str_replace('Resources', '', $model->reserve);
                                },
                            ],
                            [
                                'attribute' => 'system_name',
                                'label' => 'System',
                                'contentOptions' => ['class' => 'min-w-f-content']
                            ],
                            [
                                'attribute' => 'distance_to_arrival',
                                'label' => 'Distance from star (ls)',
                                'filter' => $dta_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ],
                            ],
                            [
                                'attribute' => 'distance',
                                'label' => 'Distance (LY)',
                                'value' => function ($model) {
                                    return $model
                                            ->distance . ' (' . Yii::$app->session->get('mt')['refSysStation'] . ')';
                                }
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
