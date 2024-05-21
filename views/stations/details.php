<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = $model['name'];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row justify-content-center overflow-x-auto'>
                <div class='details-cnt col-sm-10 col-lg-6'>
                    <h1 class="mt-2 text-custom-orange text-center sintony-bold"><?= HTML::encode($this->title) ?></h1>
                    <?= isset($model) ? DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'System',
                                'value' => Html::encode($model['system']['name']),
                                'captionOptions' => ['class' => 'w200']
                            ],
                            ['label' => 'Station type', 'value' => Html::encode($model['type'])],
                            ['label' => 'Landing pad size', 'value' => Html::encode($pad_size)],
                            ['label' => 'Distance to arrival', 'value' => Html::encode($model['distance_to_arrival'])],
                            ['label' => 'Government', 'value' => Html::encode($model['government'])],
                            ['label' => 'Allegiance', 'value' => Html::encode($model['allegiance']['faction_name'])],
                            ['label' => 'Economy (main)', 'value' =>
                                Html::encode($model['economyId1']['economy_name'])],
                            ['label' => 'Economy (secondary)', 'value' =>
                                Html::encode($model['economyId2']['economy_name'])],
                            [
                                'visible' => isset($services) ? $services['market'] : false,
                                'label' => 'Market',
                                'format' => 'raw',
                                'value' => Html::a(
                                    'Commodities',
                                    Url::toRoute([
                                        "station/market/$id"
                                        ])
                                )
                            ],
                            [
                                'visible' => isset($services) ? $services['modules'] : false,
                                'label' => 'Outfitting',
                                'format' => 'raw',
                                'value' => Html::a(
                                    'Modules',
                                    Url::toRoute([
                                        "station/ship-modules-hardpoint/$id"
                                    ])
                                )
                            ],
                            [
                                'visible' => isset($services) ? $services['ships'] : false,
                                'label' => 'Shipyard',
                                'format' => 'raw',
                                'value' => Html::a(
                                    'Ships',
                                    Url::toRoute([
                                        "station/ships/$id"
                                    ])
                                )
                            ],
                        ],
                        'options' => ['class' => 'table table-striped detail-view']
                    ]) : null ?>
                </div>
            </div>
        </div>
    </div>
</main>