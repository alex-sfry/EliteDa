<?php

/**
 * @var array $model
 */

use yii\helpers\VarDumper;
use yii\widgets\DetailView;

$this->title = $model['name'];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row justify-content-center overflow-x-auto'>
                <div class='details-cnt col-md-10 col-lg-8'>
                    <h1 class="mt-2 text-custom-orange text-center sintony-bold"><?= $this->title ?></h1>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            ['label' => 'Station', 'value' => $model['station']],
                            ['label' => 'System', 'value' => $model['system']],
                            [
                                'label' => "Upgrades ({$model['target']})",
                                'value' => function ($model) {
                                    return implode(", ", $model['upgrades']);
                                },
                                'captionOptions' => ['class' => 'text-primary'],
                                'contentOptions' => ['class' => 'text-primary sintony-bold']
                            ],
                            ['label' => 'Discovery', 'value' => $model['discovery']],
                            ['label' => 'How to get invite', 'value' => $model['get_invite']],
                            ['label' => 'Unlock', 'value' => $model['unlock']],
                            [
                                'label' => 'How to gain reputation',
                                'value' => isset($model['gain_rep']) ? $model['gain_rep'] : '',
                                'visible' => isset($model['gain_rep'])
                            ]
                        ],
                        'options' => ['class' => 'table table-striped detail-view']
                    ])?>
                </div>
            </div>
        </div>
    </div>
</main>