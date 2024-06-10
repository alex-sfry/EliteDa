<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->params['meta_keywords'] = 'Elite: Dangerous, market data, trade routes, outfitting, ships, engineers, galaxy information, stations, systems, material traders';
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 mb-4 bg-main-background align-items-center h-100">
    <div class="container-xxl px-3 align-items-center h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-5 align-items-center">
                <div class="site-signup align-items-center bg-light p-3 rounded-2 sintony-reg">
                    <h1 class="text-center text-primary"><?= Html::encode($this->title) ?></h1>
                    <p class="text-center">Please fill out the following fields to signup:</p>
                    <div class="row">
                        <div class="col align-items-center">
                            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model, 'email') ?>
                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <div class="form-group text-center">
                                <?= Html::submitButton(
                                    'Signup',
                                    ['class' => 'btn btn-primary', 'name' => 'signup-button']
                                ) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

