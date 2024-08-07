<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ar\Allegiance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="allegiance-form mb-3">
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'd-flex flex-column gap-2'
        ]
    ]); ?>

    <?php $form->fieldConfig = ['labelOptions' => ['class' => 'text-white']]; ?>

        <?= $form->field($model, 'faction_id', ['errorOptions' => ['class' => 'help-block text-danger fw-bold']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faction_name', ['errorOptions' => ['class' => 'help-block text-danger fw-bold']])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>