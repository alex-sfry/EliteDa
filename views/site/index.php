<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Elite Dangerous Assistant';
?>

<main class="flex-grow-1 mb-4">
    <div class="container-xxl px-3">
        <div class="row justify-content-evenly row-gap-3 my-4">
            <h1 class="text-center mb-4 text-light-orange fs-2"><?= Html::encode($this->title) ?></h1>
            <div class="col-4 text-light gx-0 rounded-3" style="width: 240px; height: 80px;">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                   href="<?= Url::to(['commodities/index']) ?>">
                    Commodities
                </a>
            </div>
            <div class="col-4 text-light gx-0 rounded-3 " style="width: 240px; height: 80px;">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                        justify-content-center"
                   href="<?= Url::to(['trade-routes/index']) ?>">Trader routes
                </a>
            </div>
            <div class="ol-4 text-light gx-0 rounded-3" style="width: 240px; height: 80px;">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                   href="#">
                    Engineering
                </a>
            </div>
        </div>
    </div>
</main>
