<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = $model['name'];
?>

<!-- <div class="bg-light">
    <?php /* VarDumper::dump($model, 10, true); */ ?>
</div> -->
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row justify-content-center overflow-x-auto'>
                <div class='details-cnt col-sm-10 col-lg-6'>
                    <h1 class="mt-2 text-custom-orange text-center sintony-bold"><?= HTML::encode($this->title) ?></h1>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'System',
                                'value' => $model['system']['name'],
                                'captionOptions' => ['class' => 'w200']
                            ],
                            ['label' => 'Station type', 'value' => $model['type']],
                            ['label' => 'Landing pad size', 'value' => $pad_size],
                            ['label' => 'Distance to arrival', 'value' => $model['distance_to_arrival']],
                            ['label' => 'Government', 'value' => $model['government']],
                            ['label' => 'Allegiance', 'value' => $model['allegiance']['faction_name']],
                            ['label' => 'Economy (main)', 'value' => $model['economyId1']['economy_name']],
                            ['label' => 'Economy (secondary)', 'value' => $model['economyId2']['economy_name']],
                            [
                                'label' => 'Market',
                                'format' => 'raw',
                                'value' => Html::a(
                                    'Commodities',
                                    Url::toRoute([
                                        "stations/details/{$model['market_id']}/market"
                                        ])
                                )
                            ],
                            [
                                'label' => 'Outfitting',
                                'format' => 'raw',
                                'value' => Html::a(
                                    'Modules',
                                    Url::toRoute([
                                        "stations/details/{$model['market_id']}/ship-modules"
                                        ])
                                )
                            ],
                        ],
                        'options' => ['class' => 'table table-striped detail-view']
                    ])?>
                </div>
            </div>
        </div>
    </div>
</main>