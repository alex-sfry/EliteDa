<?php

use yii\helpers\Html;

use function app\helpers\e;

$type = ['Icy' => 'Icy', 'Metal Rich' => 'Metal Rich', 'Metallic' => 'Metallic', 'Rocky' => 'Rocky'];
$maxDistanceFromRefStar = ['25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '150' => '150 LY'];
$distanceFromStar = ['Any' => 'Any', '100' => '100 ls', '500' => '500 ls', '1000' => '1000 ls', '2000' => '2000 ls'];
$sortBy = ['DistanceLy' => 'Distance (LY)', 'DistanceLs' => 'Distance (ls)'];
$selects = ['type', 'maxDistanceFromRefStar', 'distanceFromStar', 'sortBy'];
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
            <div class='row justify-content-between row-gap-lg-0 row-gap-3'>
                <div class='min-lett-spacing col-md-6 position-relative'>
                    <label for="refSystem">Ref. system:</label>
                    <select
                        class="t-sel form-select form-select-sm <?= $ref_error ?>"
                        name="refSystem"
                        id="refSystem"
                        placeholder="Type system name..."
                        aria-describedby="inputGroupPrepend3 validationServerRefSystemFeedback"
                        value="<?= $form_model->refSystem ?>"
                        required>
                        <?php if (!empty($form_model->refSystem)) : ?>
                            <option selected><?= $form_model->refSystem ?></option>
                        <?php endif; ?>
                    </select>
                    <div
                        class="invalid-feedback position-absolute fw-bold mt-0 pt-0 w-75"
                        id="validationServerRefSystemFeedback">
                        Field must not be empty
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column row-gap-3">
                    <?php foreach ($selects as $elem) : ?>
                        <div class="">
                            <label class='min-lett-spacing fw-bold' for='<?= $elem ?>'>
                                <?= $form_model->getAttributeLabel($elem) ?>
                            </label>
                            <?= Html::dropDownList(
                                $elem,
                                $form_model->$elem,
                                $$elem,
                                [
                                    'class' => 'form-select shadow-none border-dark w-100',
                                    'id' => $elem
                                ]
                            ) ?>
                        </div>
                    <?php endforeach; ?>
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