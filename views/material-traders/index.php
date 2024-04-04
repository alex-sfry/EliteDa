<?php

/**
 * @var ActiveDataProvider $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use app\widgets\InputDropdown\InputDropdown;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Material Traders';
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3 d-flex'>
            <div class='d-flex flex-column w-100'>
                <h1 class="text-light-orange text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                <div class="mt-tr-ref-idd ms-auto">
                    <?= Html::beginForm(['/material-traders/index'], 'post', [
                        'id' => 'mt-form',
                        'class' => 'bg-custom-white p-1 rounded-2',
                        'novalidate' => true,
                    ]) ?>
                        <?= InputDropdown::widget([
                            'container' => 'mt-tr-ref-idd',
                            'search' => 'ref-idd-search',
                            'to_submit' => 'ref-to-submit',
                            'placeholder' => 'Enter system',
                            'ajax' => true,
                            'endpoint' => '/systems/system/?sys=',
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
//                        ['class' => 'yii\grid\CheckboxColumn'],
                        [
                            'attribute' => 'material_type',
                            'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                            'filterInputOptions' => [
                                'class' => 'form-select',
                            ]
                        ],
                        ['attribute' => 'system.name', 'label' => 'System'],
                        ['attribute' => 'station.name', 'label' => 'Station'],
                        ['attribute' => 'station.type', 'label' => 'Station type'],
                        [
                            'attribute' => 'total',
                            'value' => function ($data) {
                                return $data->getTotal();
                            }
                        ],

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
</main>
