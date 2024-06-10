<?php

/** @var yii\web\View $this */

/** @var yii\bootstrap5\ActiveForm $form */

/** @var \app\models\forms\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->params['meta_keywords'] = 'Elite: Dangerous, market data, trade routes, outfitting, ships, engineers, galaxy information, stations, systems, material traders';

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 mb-4 bg-main-background align-items-center h-100">
    <div class="container-xxl px-3 align-items-center h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-5 align-items-center">
                <div class="site-login align-items-center bg-light p-3 rounded-2 sintony-reg">
                    <h1 class="text-center text-primary"><?= Html::encode($this->title) ?></h1>
                    <p class="text-center">Please fill out the following fields to login:</p>
                    <div class="row">
                        <div class="col align-items-center">
                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{error}",
                                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                                ],
                            ]); ?>
                            <?= $form->field($model, 'referer')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "<div class=\"custom-control custom-checkbox\">
                                                        {input} {label}</div>\n<div class=\"col-lg-8\">{error}
                                                    </div>",
                            ]) ?>
                            <div class="form-group text-center">
                                <div>
                                    <?= Html::submitButton(
                                        'Login',
                                        ['class' => 'btn btn-primary', 'name' => 'login-button']
                                    ) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>

<!--            <div style="color:#999;">-->
<!--                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>-->
<!--                To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
<!--            </div>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>