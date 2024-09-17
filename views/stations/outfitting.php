<?php

use app\widgets\TableJs\TableJs;
use yii\helpers\Url;
use yii\web\View;

use function app\helpers\d;
use function app\helpers\ksq;

$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, station outfitting, outfitting, modules';

$this->title = $station_name . ' station outfitting';
Yii::$app->view->registerCss(
    '.nav-pills .nav-link.active {
        background-color: var(--bs-info);
    }',
    [View::POS_BEGIN]
);
$this->params['breadcrumbs'] = [
    [
        'label' => $station_name,
        'url' => ['stations/details', 'id' => $id],
    ],
    $this->title
];

$categories = [
    ['label' => 'Hardpoint', 'cat' => 'hardpoint'],
    ['label' => 'Optional internal', 'cat' => 'internal'],
    ['label' => 'Utility', 'cat' => 'utility'],
    ['label' => 'Core internal', 'cat' => 'core'],
    ['label' => 'Armour', 'cat' => 'armour'],
];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row">
            <div class="col mb-3">
                <h1 class='mt-3 text-center fs-2 sintony-bold'>
                    <?= $this->title ?>
                </h1>
                <div class="text-light row flex-column flex-md-row fs-7 justify-content-lg-center">
                    <div class="max-w-f-content mx-auto mx-md-0">
                        <div class="d-flex flex-row flex-md-column gap-2 justify-content-md-center align-content-center justify-content-lg-start mt-2">

                            <!-- services side bar -->
                            <?= $this->render('_services', [
                                'id' => $id,
                                'services' => $services,
                                'active' => 'outfitting'
                            ]) ?>
                            <!-- services side bar -->

                        </div>
                    </div>
                    <div class="col col-md-10 col-lg-9 col-xl-7">
                        <div class="bg-light my-0 rounded-2 px-2 bg-transparent row"
                            style="max-width:fit-content;">
                            <ul class="nav nav-pills px-1 py-1 my-2 justify-content-start justify-content-lg-evenly 
                                    bg-light rounded-2 col-12">
                                <?php foreach ($categories as $key => $value) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 fw-bold <?= $cat === $value['cat'] ? 'active' : null ?>"
                                            aria-current="<?= $cat === $value['cat'] ? 'page' : null ?>"
                                            href="<?= Url::to([
                                                        'stations/ship-modules',
                                                        'id' => $id,
                                                        'cat' => $value['cat']
                                                    ]) ?>">
                                            <?= $value['label'] ?>
                                            <span class="top-0 start-75 badge rounded-pill bg-primary">
                                                <?= $qty_by_cat[$value['cat']] ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="col px-0">
                                <?php echo TableJs::widget([
                                    'container' => 'w-table',
                                    'model' => $models,
                                    'default_sorting' => 'asc',
                                    'columns' => [
                                        [
                                            'attribute' => 'm_name',
                                            'label' => 'Module',
                                            'filterInputOptions' => [
                                                'class' => 'form-control',
                                            ],
                                            'req_url' => 'req_url'
                                        ],
                                        [
                                            'attribute' => 'price',
                                            'label' => 'Price',
                                            'textAfter' => ' Cr',
                                            'sort' => false
                                        ],
                                        [
                                            'attribute' => 'timestamp',
                                            'label' => 'Updated',
                                            'sort' => false
                                        ],
                                    ]
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>