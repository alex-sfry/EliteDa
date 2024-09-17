<?php

/** @var yii\web\View $this */
/** @var array $errors */
/** @var array $form_values */
/** @var array $module_names */
/** @var ShipModulessForm $form */

use yii\helpers\Html;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;
use function app\helpers\e;

$landingPadSizes = ['L' => 'L', 'M' => 'M', 'S' => 'S'];
$incl_surface = ['No' => 'No', 'Yes' => 'Yes'];
$max_dist_from_star = [
    'Any' => 'Any',
    '100' => '100 ls',
    '500' => '500 ls',
    '1000' => '1000 ls',
    '2000' => '2000 ls',
];
$col2 = [
    'landingPadSize' => $landingPadSizes,
    'includeSurface' => $incl_surface,
    'distanceFromStar' => $max_dist_from_star,
];

$labels = $form->attributeLabels();
$search_name_cls = isset($errors['refSystem']) ? 'is-invalid' : null;
$search_mod_cls = isset($errors['cMainSelect']) ? 'is-invalid' : null;
// d($module_names);
?>

<?= Html::beginForm(
    ['/ship-modules/'],
    'get',
    [
        'id' => 'adv-mod-form',
        'novalidate' => true,
        'class' => [
            'get-form',
            'c-form',
            'fs-7',
            'bg-light',
            'py-1',
            'px-1',
            'w-100'
        ],
    ]
) ?>

<div class='d-flex flex-column justify-content-between'>
    <div class='row justify-content-center justify-content-sm-between flex-wrap gap-1 gap-sm-0'>

        <!-- form column 1 -->
        <div class='col-md-7'>
            <div class="d-flex flex-column">
                <label class="tselect-lbl-2" for="cMainSelect"><?= $labels['cMainSelect'] ?>:</label>
                <select
                    class="t-sel form-select form-select-sm mb-3 <?= $search_mod_cls ?>"
                    name="cMainSelect[]"
                    id="cMainSelect"
                    placeholder="Select ships..."
                    aria-describedby="inputGroupPrepend3 validationServerCMainSelectFeedback"
                    multiple
                    required>
                    <?php foreach ($module_names as $key => $value) { ?>
                        <option
                            class="opacity-0"
                            value="<?= $key ?>"
                            <?= ArrayHelper::isIn($key, $form_values['cMainSelect']) ? 'selected' : null ?>>
                            <?= $value ?>
                        </option>
                    <?php } ?>
                </select>
                <div
                    class="invalid-feedback fw-bold mt-0 pt-0"
                    id="validationServerCMainSelectFeedback">
                    <?= $errors['cMainSelect'][0] ?? 'Field must not be empty' ?>
                </div>
            </div>
            <div class="d-flex flex-column">
                <label class='tselect-lbl-1' for="refSystem"><?= $labels['refSystem'] ?>:</label>
                <select
                    class="t-sel form-select form-select-sm mb-3 <?= $search_name_cls ?>"
                    name="refSystem"
                    id="refSystem"
                    placeholder="Type system name..."
                    aria-describedby="inputGroupPrepend3 validationServerRefSystemFeedback"
                    value="<?= e($form_values['refSystem']) ?>"
                    required>
                    <?php if (!empty($form_values['refSystem'])) : ?>
                        <option selected><?= e($form_values['refSystem']) ?></option>
                    <?php endif; ?>
                </select>
                <div
                    class="invalid-feedback fw-bold mt-0 pt-0"
                    id="validationServerRefSystemFeedback">
                    <?= $errors['refSystem'][0] ?? 'Field must not be empty' ?>
                </div>
            </div>
        </div>
        <!-- end of form column 1 -->

        <!-- form column 2 -->
        <div class='col-md-5'>
            <?php foreach ($col2 as $key => $value) { ?>
                <div class="d-flex flex-column">
                    <label for="<?= $key ?>"><?= $labels[$key] ?>:</label>
                    <?= Html::dropDownList(
                        $key,
                        $form_values[$key],
                        $value,
                        ['id' => $key, 'class' => 'form-select form-select-sm mb-3']
                    ) ?>
                </div>
            <?php } ?>
        </div>
        <!-- end of form column 2 -->

    </div>
    <div class="mt-4 d-flex col-sm-6 col-md-6 col-lg-5 justify-content-center align-self-center">
        <button
            class='btn btn-sm btn-primary w-100 fw-bold text-uppercase'
            type='submit'
            name='formBtn'>
            Search
        </button>
    </div>
</div>