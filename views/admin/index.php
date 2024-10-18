<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Admin';
$this->params['breadcrumbs'][] = $this->title;
?>

<main class="flex-grow-1 mb-4 bg-main-background text-white">
    <div class="container-xxl px-3 h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-xl-3 col-md-4 col-xs align-self-center just">
                <div class="d-flex flex-column gap-2">
                    <a href="<?= Url::to(['allegiance/index']) ?>" class="btn btn-success">
                        Allegiance CRUD
                    </a>
                    <a href="<?= Url::to(['ship-modules-list/index']) ?>" class="btn btn-success">
                        Outfitting CRUD
                    </a>
                    <a href="<?= Url::to(['ships-list/index']) ?>" class="btn btn-success">
                        Shipyard CRUD
                    </a>
                    <a href="<?= Url::to(['modules-price-list/index']) ?>" class="btn btn-success">
                        Modules Price List CRUD
                    </a>
                    <a href="<?= Url::to(['ships-price-list/index']) ?>" class="btn btn-success">
                        Ships Price List CRUD
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
    