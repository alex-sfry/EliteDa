<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \app\models\forms\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
// $this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 mb-4 bg-main-background">
    <div class="container-xxl px-3">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="site-contact">
                    <h1 class="text-center fs-2 mt-3"><?= Html::encode($this->title) ?></h1>
                    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) : ?>
                    <div class="alert alert-success text-center bg-light">
                        Thank you for contacting us. We will respond to you as soon as possible.
                    </div>
                    <!-- <p class="text-center">
                        Note that if you turn on the Yii debugger, you should be able
                        to view the mail message on the mail panel of the debugger.
                        <?php if (Yii::$app->mailer->useFileTransport) : ?>
                            Because the application is in development mode, the email is not sent but saved as
                            a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                            Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                            application component to be false to enable email sending.
                        <?php endif; ?>
                    </p> -->
                    <?php else : ?>
                    <p class="text-center text-light">
                        If you have business inquiries or other questions, please fill out the following form to 
                        contact us.
                        Thank you.
                    </p>
                    <div class="row justify-content-center sintony-bold text-light">
                        <div class="col-md-7 col-lg-5">
                            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                                <?= $form->field($model, 'email') ?>
                                <?= $form->field($model, 'subject') ?>
                                <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
                                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                                    'template' =>
                                        '<div class="row gap-4"><div class="col-lg-3">
                                        {image}</div><div class="col-lg-6">{input}</div></div>',
                                ]) ?>
                                <div class="form-group text-center mt-2">
                                    <?= Html::submitButton(
                                        'Submit',
                                        ['class' => 'btn btn-primary', 'name' => 'contact-button']
                                    ) ?>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</main>
