<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipsPriceList $model */

$this->title = 'Update Ships Price List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ships Price Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-price-list-update container-xxl px-5 mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</main>

