<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\ShipModulesListSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ship-modules-list-search mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
        'class' => 'd-flex flex-column gap-2',
            ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'symbol') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'mount') ?>

    <?= $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'guidance') ?>

    <?php // echo $form->field($model, 'ship') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'entitlement') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
