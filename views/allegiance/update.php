<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ar\Allegiance $model */

$this->title = 'Update Allegiance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Allegiances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="allegiance-update container-xxl px-5 mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</main>

