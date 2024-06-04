<?php

use app\models\ar\Materials;
use app\models\search\MaterialsSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/** @var Materials $model */
/** @var MaterialsSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */
/** @var View $this */

$this->title = "Materials";
$this->params['breadcrumbs'] = [$this->title];
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'attribute' => 'name',
                                'label' => 'Material',
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='materialssearch-name'
                                            name='MaterialsSearch[name]'
                                            value='{$queryParams['MaterialsSearch']['name']}'>
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
                                'attribute' => 'category',
                                'label' => 'Category',
                                'filter' => "
                                    <div class='input-group input-group-sm'>
                                        <input 
                                            type='text' 
                                            class='form-control form-control-sm' 
                                            id='materialssearch-category'
                                            name='MaterialsSearch[category]'
                                            value='{$queryParams['MaterialsSearch']['category']}'>
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
                                'attribute' => 'grade',
                                'label' => 'Grade',
                                'filter' => [
                                    'Very Common' => 'Very Common',
                                    'Common' => 'Common',
                                    'Standard' => 'Standard',
                                    'Rare' => 'Rare',
                                    'Very Rare' => 'Very Rare',
                                ],
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                    'id' => null
                                ]
                            ],
                            [
                                'attribute' => 'type',
                                'label' => 'Type',
                                'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                    'id' => null
                                ]
                            ],
                            [
                                'attribute' => 'location',
                                'label' => 'Location',
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
