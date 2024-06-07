<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\ksq;

$this->title = $model['name'];
$this->params['breadcrumbs'] = [$this->title];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row justify-content-center overflow-x-auto'>
                <div class='details-cnt col-sm-10 col-lg-6'>
                    <h1 class="mt-2 text-center sintony-bold"><?= ksq($this->title) ?></h1>
                    <?php $system_id = Html::encode($model['system_id']) ?>
                    <?= isset($model) ? DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'System',
                                'format' => 'raw',
                                'captionOptions' => ['class' => 'w200'],
                                'value' => Html::a(
                                    Html::encode($model['system']['name']),
                                    Url::toRoute([
                                        "system/$system_id"
                                    ]),
                                    ['class' => 'text-decoration-underline link-underline-primary table-link']
                                )
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
                                'visible' => $eng_name ? true : false,
                                'captionOptions' => ['class' => 'text-primary'],
                                'label' => 'Engineer',
                                'format' => 'raw',
                                'value' => Html::a(
                                    $eng_name,
                                    Url::toRoute([
                                        "engineer/$eng_id"
                                    ]),
                                    [
                                        'class' => 'text-decoration-underline link-underline-primary table-link 
                                                    text-primary sintony-bold'
                                    ]
                                )
                            ],
                            [
                                'visible' => count($model['mat_traders']) > 0 ? true : false,
                                'captionOptions' => ['class' => 'text-primary'],
                                'label' => 'Material traders',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $mat_types = '';
                                    foreach ($model['mat_traders'] as $item) {
                                        $mat_types .= '<span class="d-block text-primary sintony-bold">' .
                                            Html::encode($item->material_type) . '</span>';
                                    }

                                    return $mat_types;
                                }
                            ],
                            [
                                'label' => 'Market',
                                'format' => 'raw',
                                'value' => $services['market'] ?
                                    Html::a(
                                        'Commodities',
                                        Url::toRoute([
                                            "station/market/$id"
                                        ]),
                                        [
                                            'class' => 'text-decoration-underline link-underline-primary table-link'
                                        ]
                                    ) : '---'
                            ],
                            [
                                'label' => 'Outfitting',
                                'format' => 'raw',
                                'value' => $services['modules'] ?
                                    Html::a(
                                        'Modules',
                                        Url::toRoute([
                                            "station/ship-modules-hardpoint/$id"
                                        ]),
                                        [
                                            'class' => 'text-decoration-underline link-underline-primary table-link'
                                        ]
                                    ) : '---'
                            ],
                            [
                                'label' => 'Shipyard',
                                'format' => 'raw',
                                'value' => $services['ships'] ?
                                    Html::a(
                                        'Ships',
                                        Url::toRoute([
                                            "station/ships/$id"
                                        ]),
                                        [
                                            'class' => 'text-decoration-underline link-underline-primary table-link'
                                        ]
                                    ) : '---'
                            ],
                        ],
                        'options' => ['class' => 'table table-striped detail-view']
                    ]) : null ?>
                </div>
            </div>
        </div>
    </div>
</main>