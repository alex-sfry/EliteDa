<?php

use app\models\search\MaterialsSearch;
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

$this->title = 'Material Traders';
$this->params['breadcrumbs'] = [$this->title];
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
                            [Url::to(ArrayHelper::merge(['/material-traders/index'], $queryParams))],
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
                        'columns' => [
                            [
                                'attribute' => 'material_type',
                                'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                    'id' => null
                                ]
                            ],
                            [
                                'attribute' => 'system.name',
                                'label' => 'System',
                                'value' => function ($model) {
                                    return Html::a(
                                        Html::encode($model->system->name),
                                        Url::toRoute(["system/{$model->system->id}"]),
                                        ['class' => [
                                            'text-decoration-underline',
                                            'link-underline-primary',
                                            'table-link'
                                            ]
                                        ]
                                    );
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'station.name',
                                'label' => 'Station',
                                'value' => function ($model) {
                                    return Html::a(
                                        Html::encode($model->station->name),
                                        Url::toRoute(["station/{$model->station->id}"]),
                                        ['class' => [
                                            'text-decoration-underline',
                                            'link-underline-primary',
                                            'table-link'
                                            ]
                                        ]
                                    );
                                },
                                'format' => 'raw'
                            ],
                            ['attribute' => 'station.type', 'label' => 'Station type'],
                            [
                                'attribute' => 'distance',
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
