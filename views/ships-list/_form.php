<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ar\ShipsList $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ships-list-form">

    <?php
    $form = ActiveForm::begin(
        [
            'options' => [
                'class' => 'd-flex flex-column gap-2'
            ]
        ]
    );
    ?>

    <?php $filedOptions = ['errorOptions' => ['class' => 'help-block text-danger fw-bold']] ?>
    <?php $form->fieldConfig = ['labelOptions' => ['class' => 'text-white']]; ?>

    <?= $form->field($model, 'id', $filedOptions)->textInput() ?>

    <?= $form->field($model, 'symbol', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name', $filedOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entitlement', $filedOptions)->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>