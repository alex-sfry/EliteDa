<?php

use app\widgets\TableJs\TableJs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = $station_name . ' outfitting';
?>
<style>
    .nav-pills .nav-link.active {
        background-color: var(--bs-light-orange);
    }
</style>
<div class="bg-light">
    <?php
    // echo Html::a(
    //     'Commodities',
    //     Url::to(ArrayHelper::merge(['commodities/index'], $commodities_req_arr))
    // ) . '<br><br>';
    // VarDumper::dump($models, 10, true);
    ?>
</div>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row text-center">
            <div class="col mb-3">
                <h1 class='mt-3 text-center fs-2 text-custom-orange sintony-bold'>
                    <?= Html::encode($this->title) ?>
                </h1>
                <div class="text-light d-flex flex-column flex-md-row fs-7">
                    <div class="d-flex flex-row flex-md-column gap-2 justify-content-center 
                                justify-content-md-start mt-2">
                        <div class="small-tile text-light gx-0 rounded-3">
                            <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                    justify-content-center"
                                href="<?= Url::to(["station/$id"]) ?>">
                                    station info
                                </a>
                        </div>
                        <div class="small-tile text-light gx-0 rounded-3">
                            <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                    justify-content-center"
                                href="<?= Url::toRoute(["station/market/$id"]) ?>">
                                    market
                                </a>
                        </div>
                        <div class="small-tile text-light gx-0 rounded-3">
                            <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                    justify-content-center active"
                                href="<?= Url::toRoute(["station/ship-modules-hardpoint/$id"]) ?>">
                                    outfitting
                                </a>
                        </div>
                        <div class="small-tile text-light gx-0 rounded-3">
                            <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                                        justify-content-center"
                                href="<?= Url::toRoute(["station/ship-modules-hardpoint/$id"]) ?>">
                                    ships
                                </a>
                        </div>
                    </div>
                    <div class="bg-light my-0 mx-auto rounded-2 px-2 bg-transparent" style="max-width:fit-content;">
                        <ul class="nav nav-pills px-1 py-1 my-2 justify-content-center bg-white rounded-2">
                            <li class="nav-item">
                                <a class="nav-link light-orange px-2 <?= $cat === 'hardpoint' ? 'active' : null ?>"
                                    aria-current="<?= $cat === 'hardpoint' ? 'page' : null ?>" 
                                    href="<?= Url::to([
                                        'stations/ship-modules',
                                        'id' => $id,
                                        'cat' => 'hardpoint']) ?>">
                                    Hardpoint
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
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link light-orange <?= $cat === 'armour' ? 'active' : null ?>"
                                    aria-current="<?= $cat === 'armour' ? 'page' : null ?>"
                                    href="<?= Url::to([
                                        'stations/ship-modules',
                                        'id' => $id,
                                        'cat' => 'armour'
                                        ]) ?>">
                                    Armour
                                </a>
                            </li>
                        </ul>
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
                                    ]
                                ],
                                [
                                    'attribute' => 'price',
                                    'label' => 'Price',
                                    'textAfter' => ' Cr',
                                    'sort' => false
                                ],
                            ]]); ?>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</main>