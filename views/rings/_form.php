<?php

/**
 * @var yii\web\View $this
 * @var app\models\forms\RingsForm $form_model
 */

use yii\helpers\Html;

use function app\helpers\e;

$type = ['Icy' => 'Icy', 'Metal Rich' => 'Metal Rich', 'Metallic' => 'Metallic', 'Rocky' => 'Rocky'];
?>

<?= Html::beginForm(
    ['/rings/index'],
    'get',
    [
        'id' => 'rings-form',
        'novalidate' => true,
        'class' => 'c-form fs-7 bg-light py-1 rounded-2 w-100 d-flex flex-column novalidate',
    ]
) ?>
<div class='container-xxl'>
    <div class="row justify-content-center">
        <div class='d-flex flex-column justify-content-between gap-4'>
            <div class='row justify-content-center row-gap-lg-0 row-gap-3'>
                <div class='min-lett-spacing col position-relative'>
                    <label class='tselect-lbl-1' for="refSystem">Ref. system:</label>
                    <select
                        class="t-sel form-select-sm 
                        <?= !empty($form_model->getErrors('refSystem')) ? 'is-invalid' : '' ?>"
                        name="refSystem"
                        id="refSystem"
                        placeholder="Type system name..."
                        aria-describedby="inputGroupPrepend3 validationServerRefSystemFeedback"
                        value="<?= e($form_model->refSystem) ?>"
                        required>
                        <?php if (!empty($form_model->refSystem)) : ?>
                            <option selected><?= e($form_model->refSystem) ?></option>
                        <?php  endif; ?>
                    </select>
                    <div
                        class="invalid-feedback position-absolute fw-bold mt-0 pt-0 w-75"
                        id="validationServerRefSystemFeedback">
                        Field must not be empty
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 mb-1 d-flex col-sm-6 col-md-6 col-lg-5 justify-content-center">
            <button
                class='btn btn-sm btn-primary w-100 fw-bold text-uppercase'
                type='submit'
                name='c-form-submit'>
                Search
            </button>
        </div>
    </div>
</div>
<?php Html::endForm() ?>