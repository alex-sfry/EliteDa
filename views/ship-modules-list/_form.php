<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipModulesList $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ship-modules-list-form mb-3">
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'd-flex flex-column gap-2'
        ]
    ]); ?>

    <?php $filedOptions = ['errorOptions' => ['class' => 'help-block text-danger fw-bold']] ?>
    <?php $form->fieldConfig = ['labelOptions' => ['class' => 'text-white']]; ?>

    <?= $form->field($model, 'id', $filedOptions)->textInput() ?>

    <?= $form->field($model, 'symbol', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mount', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guidance', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ship', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class', $filedOptions)->textInput() ?>

    <?= $form->field($model, 'rating', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entitlement', $filedOptions)->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>