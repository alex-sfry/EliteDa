<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipModulesList $model */

$this->title = 'Create Ship Modules List';
$this->params['breadcrumbs'][] = ['label' => 'Ship Modules Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ship-modules-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
