<?php

use yii\helpers\Html;
use app\assets\AdminAsset;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipsList $model */

$this->title = 'Create Ships List';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ships Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AdminAsset::register($this);
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-list-create container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</main>
