<?php

/**
 * @var ActiveDataProvider $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Materials";
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-light-orange text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['attribute' => 'name', 'label' => 'Material'],
                            ['attribute' => 'category', 'label' => 'Category'],
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
                                    'class' => 'form-select',
                                ],
                            ],
                            [
                                'attribute' => 'type',
                                'label' => 'Type',
                                'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                                'filterInputOptions' => [
                                    'class' => 'form-select',
                                ],
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
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>
