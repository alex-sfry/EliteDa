<?php

/** @var yii\web\View $this */
/** @var array $errors */
/** @var array $adv_form_values */
/** @var StationsAdvancedForm $by_name_form */


use yii\helpers\Html;

use function app\helpers\d;
use function app\helpers\e;

$pad_options = [
    'L' => 'L',
    'M' => 'M',
    'S' => 'S',
];

$incl_surface = ['No' => 'No', 'Yes' => 'Yes(w/o Odyssey)', 'Odyssey' => 'Yes(w/ Odyssey)'];

$dta_options = [
    'Any' => 'Any',
    '500' => '500 ls',
    '1000' => '1000 ls',
    '2000' => '2000 ls',
    '5000' => '5000 ls',
];

$allegiance_options = [
    'Any' => 'Any',
    'Alliance' => 'Alliance',
    'Empire' => 'Empire',
    'Federation' => 'Federation',
    'Independent' => 'Independent',
    'None' => 'None',
    'Pirate' => 'Pirate'
];

$economy_options = [
    'Any' => 'Any',
    'Agriculture' => 'Agriculture',
    'Colony' => 'Colony',
    'Damaged' => 'Damaged',
    'Extraction' => 'Extraction',
    'High Tech' => 'High Tech',
    'Industrial' => 'Industrial',
    'Military' => 'Military',
    'None' => 'None',
    'Prison' => 'Prison',
    'Private Enterprise' => 'Private Enterprise',
    'Refinery' => 'Refinery',
    'Repair' => 'Repair',
    'Rescue' => 'Rescue',
    'Service' => 'Service',
    'Terraforming' => 'Terraforming',
    'Tourism' => 'Tourism',
    'Engineering' => 'Engineering'
];

$gov_options = [
    'Any' => 'Any',
    'Anarchy' => 'Anarchy',
    'Communism' => 'Communism',
    'Confederacy' => 'Confederacy',
    'Cooperative' => 'Cooperative',
    'Corporate' => 'Corporate',
    'Democracy' => 'Democracy',
    'Dictatorship' => 'Dictatorship',
    'Feudal' => 'Feudal',
    'Patronage' => 'Patronage',
    'Prison colony' => 'Prison colony',
    'Theocracy' => 'Theocracy',
    'Workshop (Engineer)' => 'Workshop (Engineer)',
    'Engineer' => 'Engineer',
];

$col1 = [
    'pad' => $pad_options,
    'inclSurface' => $incl_surface,
];

$col2 = [
    'dta' => $dta_options,
    'government' => $gov_options,
    'allegiance' => $allegiance_options,
    'economy' => $economy_options
];

$labels_adv = $adv_form->attributeLabels();
$search_name_cls = !empty($errors) ? 'is-invalid' : null;
?>

<?= Html::beginForm(
    ['/stations/'],
    'get',
    [
        'id' => 'adv-sys-form',
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
        <div class='col-6 col-sm w-100'>
            <div class="d-flex flex-column position-relative">
                <label class='tselect-lbl-1' for="refSystem"><?= $labels_adv['refSystem'] ?>:</label>
                <select
                    class="t-sel form-select form-select-sm mb-3 <?= $search_name_cls ?>"
                    name="refSystem"
                    id="refSystem"
                    placeholder="Type system name..."
                    aria-describedby="inputGroupPrepend3 validationServerRefSystemFeedback"
                    value="<?= e($adv_form_values['refSystem']) ?>"
                    required>
                    <?php if (!empty($adv_form_values['refSystem'])) : ?>
                        <option selected><?= e($adv_form_values['refSystem']) ?></option>
                    <?php endif; ?>
                </select>
                <div
                    class="invalid-feedback fw-bold mt-0 pt-0"
                    id="validationServerRefSystemFeedback">
                    <?= $errors['refSystem'][0] ?? 'Field must not be empty' ?>
                </div>
            </div>
            <?php foreach ($col1 as $key => $value) { ?>
                <div class="d-flex flex-column">
                    <label for="<?= $key ?>"><?= $labels_adv[$key] ?>:</label>
                    <?= Html::dropDownList(
                        $key,
                        $adv_form_values[$key],
                        $value,
                        ['id' => $key, 'class' => 'form-select form-select-sm mb-3']
                    ) ?>
                </div>
            <?php } ?>
        </div>
        <!-- end of form column 1 -->

        <!-- form column 2 -->
        <div class='col-6 col-sm w-100'>
            <?php foreach ($col2 as $key => $value) { ?>
                <div class="d-flex flex-column">
                    <label for="<?= $key ?>"><?= $labels_adv[$key] ?>:</label>
                    <?= Html::dropDownList(
                        $key,
                        $adv_form_values[$key],
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
            name='advFormBtn'>
            Search
        </button>
    </div>
</div>