<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipModulesList $model */

$this->title = 'Update Ship Modules List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ship Modules Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ship-modules-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
