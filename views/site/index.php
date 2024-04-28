<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Elite Dangerous Assistant';
?>

<main class="flex-grow-1 mb-4 bg-main-background">
    <div class="container-xxl px-3">
        <div class="row justify-content-evenly row-gap-4">
            <h1 class="text-center mb-4 text-light-orange fs-2 mt-3"><?= Html::encode($this->title) ?></h1>
            <div class="main-tile col-6 col-sm-4 text-light rounded-3">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                   href="<?= Url::to(['commodities/index']) ?>">
                    Commodities
                </a>
            </div>
            <div class="main-tile col-6 col-sm-4 text-light rounded-3 shr">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                        justify-content-center"
                   href="<?= Url::to(['trade-routes/index']) ?>">Trader routes
                </a>
            </div>
            <div class="col-tile col-6 col-sm-4 row-gap-2 d-flex flex-column align-content-end">
                <div class="main-tile text-light gx-0 rounded-3">
                    <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                       href="<?= Url::to(['engineers/index']) ?>">
                        Engineers
                    </a>
                </div>
                <div class="main-tile text-light rounded-3">
                    <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                       href="<?= Url::to(['material-traders/index']) ?>">
                        Material traders
                    </a>
                </div>
                <div class="main-tile text-light gx-0 rounded-3">
                    <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                       href="<?= Url::to(['materials/index']) ?>">
                        Materials
                    </a>
                </div>
            </div>
            <div class="main-tile col-6 col-sm-4 text-light rounded-3 shr">
                <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column
                        justify-content-center"
                   href="<?= Url::to(['ship-modules/index']) ?>">Ship modules
                </a>
            </div>
        </div>
    </div>
</main>
