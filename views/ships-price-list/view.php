<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipsPriceList $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ships Price Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-price-list-view container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'name' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                    'name',
            'price',
        ],
        ]) ?>

    </div>
</main>