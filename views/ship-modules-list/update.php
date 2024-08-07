<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipModulesList $model */

$this->title = 'Update Ship Modules List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin-dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ship Modules Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ship-modules-list-update container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</main>

