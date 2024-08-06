<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipsList $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ships Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-list-view container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'symbol' => $model->symbol], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'symbol' => $model->symbol], [
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
                'id',
                'symbol',
                'name',
                'entitlement:ntext',
            ],
        ]) ?>
    </div>
</main>