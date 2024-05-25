<?php

use app\widgets\TableJs\TableJs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

use function app\helpers\d;

$this->title = Html::encode($station_name) . ' station outfitting';
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
?>
<?php
// d($models);
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
                        <div class="d-flex flex-row flex-md-column gap-2 justify-content-md-center align-content-center 
                                    justify-content-lg-start mt-2">
                            <div class="small-tile text-light gx-0 rounded-3">
                                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                        justify-content-center sintony-bold"
                                    href="<?= Url::to(["station/$id"]) ?>">
                                        station info
                                    </a>
                            </div>
                            <div class="small-tile text-light gx-0 rounded-3">
                                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                        justify-content-center  sintony-bold 
                                        <?= !$services['market'] ? 'disabled' : null ?>"
                                    href="<?= $services['market'] ?
                                        Url::toRoute(["station/market/$id"]) : Url::to() ?>">
                                        market
                                    </a>
                            </div>
                            <div class="small-tile text-light gx-0 rounded-3">
                                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                        justify-content-center active sintony-bold"
                                    href="<?= Url::toRoute(["station/ship-modules-hardpoint/$id"]) ?>">
                                        outfitting
                                    </a>
                            </div>
                            <div class="small-tile text-light gx-0 rounded-3">
                                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                            justify-content-center  sintony-bold 
                                            <?= !$services['ships'] ? 'disabled' : null ?>"
                                    href="<?= $services['market'] ?
                                        Url::toRoute(["station/ships/$id"]) : Url::to() ?>">
                                        ships
                                    </a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-10 col-lg-9 col-xl-7">
                        <div class="bg-light my-0 rounded-2 px-2 bg-transparent row" 
                            style="max-width:fit-content;">
                            <ul class="nav nav-pills px-1 py-1 my-2 justify-content-start justify-content-lg-evenly 
                                    bg-light rounded-2 col-12">
                                <li class="nav-item">
                                    <a class="nav-link px-2 <?= $cat === 'hardpoint' ? 'active' : null ?>"
                                        aria-current="<?= $cat === 'hardpoint' ? 'page' : null ?>" 
                                        href="<?= Url::to([
                                            'stations/ship-modules',
                                            'id' => $id,
                                            'cat' => 'hardpoint']) ?>">
                                        Hardpoint
                                        <span class="top-0 start-75 badge rounded-pill bg-primary">
                                            <?= $qty_by_cat['hardpoint'] ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= $cat === 'internal' ? 'active' : null ?>" 
                                        aria-current="<?= $cat === 'internal' ? 'page' : null ?>" 
                                        href="<?= Url::to([
                                            'stations/ship-modules',
                                            'id' => $id,
                                            'cat' => 'internal'
                                            ]) ?>">
                                        Optional internal
                                        <span class="top-0 start-75 badge rounded-pill bg-primary">
                                            <?= $qty_by_cat['internal'] ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= $cat === 'utility' ? 'active' : null ?>"
                                        aria-current="<?= $cat === 'utility' ? 'page' : null ?>"
                                        href="<?= Url::to([
                                            'stations/ship-modules',
                                            'id' => $id,
                                            'cat' => 'utility'
                                            ]) ?>">
                                        Utility
                                        <span class="top-0 start-75 badge rounded-pill bg-primary">
                                            <?= $qty_by_cat['utility'] ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= $cat === 'core' ? 'active' : null ?>"
                                        aria-current="<?= $cat === 'core' ? 'page' : null ?>" 
                                        href="<?= Url::to([
                                            'stations/ship-modules',
                                            'id' => $id,
                                            'cat' => 'core'
                                            ]) ?>">
                                        Core internal
                                        <span class="top-0 start-75 badge rounded-pill bg-primary">
                                            <?= $qty_by_cat['core'] ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= $cat === 'armour' ? 'active' : null ?>"
                                        aria-current="<?= $cat === 'armour' ? 'page' : null ?>"
                                        href="<?= Url::to([
                                            'stations/ship-modules',
                                            'id' => $id,
                                            'cat' => 'armour'
                                            ]) ?>">
                                        Armour
                                        <span class="top-0 start-75 badge rounded-pill bg-primary">
                                            <?= $qty_by_cat['armour'] ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="col px-0">
                                <?php  echo TableJs::widget([
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
                                    ]]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>