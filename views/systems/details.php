<?php

use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\d;
use function app\helpers\ksq;

/**
 * @var array $models
 * @var array $model
 */

$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, system information';
$this->title = $model['name'];
$this->params['breadcrumbs'] = [
    [
        'label' => 'Search for systems',
        'url' => Url::toRoute([
            "systems/index"
        ]),
    ],
    $this->title
];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='wrapper d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row justify-content-center overflow-x-auto'>
                <div class='details-cnt col-sm-10 col-lg-6'>
                    <h1 class="mt-2 text-center sintony-bold"><?= ksq($this->title) ?></h1>
                    <p class=" text-center sintony-bold fs-4">system info:</p>
                    <?= isset($model) ? DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Population',
                                'value' => Yii::$app->formatter->asInteger((int)$model['population'])
                            ],
                            [
                                'label' => 'Security',
                                'value' => $model['security']['security_level']
                            ],
                            ['label' => 'Economy', 'value' => $model['economy']['economy_name']],
                            ['label' => 'Allegiance', 'value' => $model['allegiance']['faction_name']],
                            [
                                'label' => 'Stations',
                                'value' => function ($model) {
                                    if (!isset($model['stations']) || count($model['stations']) < 1) {
                                        return;
                                    }
                                    if (count($model['stations']) < 1) {
                                        return;
                                    }

                                    $stations_str = '';
                                    ArrayHelper::multisort($model['stations'], 'name', SORT_ASC);

                                    foreach ($model['stations'] as $item) {
                                        $stations_str .= '<li class="list-group-item">' .
                                            Html::a(
                                                $item['name'],
                                                Url::toRoute([
                                                    "station/{$item['id']}"
                                                ]),
                                                [
                                                    'class' => match ($item['type']) {
                                                        'Planetary Outpost',
                                                        'Planetary Port',
                                                        'Odyssey Settlement' => 'nav-info text-success sintony-bold',
                                                        default => 'nav-info text-primary sintony-bold'
                                                    }
                                                ]
                                            );
                                    }

                                    return '
                                    <div class="d-flex justify-content-start mb-2 ms-1">
                                        <div class="c-result-legend-item d-flex justify-content-start 
                                                    column-gap-1 pe-1 align-items-center">
                                            <div class="c-result-legend-item-color bg-success h-100"></div>
                                            - surface
                                        </div>
                                        <div class="c-result-legend-item d-flex justify-content-start 
                                                    column-gap-1 align-items-center">
                                            <div class="c-result-legend-item-color bg-primary ms-2 h-100"></div>
                                            - space
                                        </div>
                                    </div>
                                    <ul class="list-group">' . $stations_str . '</ul>
                                    ';
                                },
                                'format' => 'raw'
                            ],
                        ],
                        'options' => ['class' => 'table table-striped detail-view']
                    ]) : null ?>
                </div>
            </div>
        </div>
    </div>
</main>
