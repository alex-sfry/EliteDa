<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\AllegianceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="allegiance-search mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
        'class' => 'd-flex flex-column gap-2',
            ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'faction_id') ?>

    <?= $form->field($model, 'faction_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
