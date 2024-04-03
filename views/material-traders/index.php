<?php

/**
 * @var ActiveDataProvider $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use app\widgets\InputDropdown\InputDropdown;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Material Traders';
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3 d-flex'>
            <div class='d-flex flex-column w-100'>
                <h1 class="text-light-orange text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                <div class="mt-tr-ref-idd ms-auto">
                    <?= InputDropdown::widget([
                        'container' => 'mt-tr-ref-idd',
//                        'error' => $ref_error,
//                        'selected' => $form_model->refSysStation,
                        'search' => 'ref-idd-search',
                        'to_submit' => 'ref-to-submit',
                        'placeholder' => 'Enter system',
                        'ajax' => true,
                        'endpoint' => '/systems/system/?sys=',
                        'label_main' => 'Ref. system:',
                        'toggle_btn_text' => 'Search',
                        'name_main' => 'refSysStation',
                        'required' => 'required',
                        'btn_position' => 'right',
                        'input_bg' => 'bg-white'
                    ]); ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//                        ['class' => 'yii\grid\CheckboxColumn'],
                        ['attribute' => 'id'],
                        [
                            'attribute' => 'material_type',
                            'filter' => ['Encoded' => 'Encoded', 'Manufactured' => 'Manufactured', 'Raw' => 'Raw'],
                            'filterInputOptions' => [
                                'class' => 'form-select',
                            ]
                        ],
                        ['attribute' => 'system_id'],
                        ['attribute' => 'station_id'],
                        // ...
                    ],
                    'pager' => [
                        'class' => 'yii\bootstrap5\LinkPager'
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</main>
