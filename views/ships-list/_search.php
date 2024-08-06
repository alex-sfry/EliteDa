<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\ShipsListSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ships-list-search mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'd-flex flex-column gap-2'
        ]
    ]); ?>

    <?php $form->fieldConfig = ['labelOptions' => ['class' => 'text-white']]; ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entitlement')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>