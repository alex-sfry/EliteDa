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
                <div class="bg-light my-0 mx-auto rounded-2 px-2 bg-transparent" style="max-width:fit-content;">
                    <ul class="nav nav-pills px-3 py-2 my-2 justify-content-center bg-white rounded-2">
                        <li class="nav-item">
                            <a class="nav-link light-orange <?= $cat === 'armour' ? 'active' : null ?>"
                                aria-current="page" href="<?= Url::to([
                                    'stations/ship-modules',
                                    'id' => $market_id,
                                    'cat' => 'armour']) ?>">
                                Armour
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $cat === 'core' ? 'active' : null ?>" href="<?= Url::to([
                                    'stations/ship-modules',
                                    'id' => $market_id,
                                    'cat' => 'core']) ?>">
                                Core internal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $cat === 'internal' ? 'active' : null ?>" href="<?= Url::to([
                                    'stations/ship-modules',
                                    'id' => $market_id,
                                    'cat' => 'internal']) ?>">
                                Optional internal
                            </a>
                        </li>
                    </ul>
                    <?= TableJs::widget([
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
                                'textAfter' => ' Cr'
                            ],
                        ]]); ?>
                </div>
            </div>
        </div>
    </div>
</main>