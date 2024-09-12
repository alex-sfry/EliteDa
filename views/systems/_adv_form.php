<?php

/**
 * @var yii\web\View $this
 * @var SystemsAdvancedForm $adv_form
 * @var array $adv_form_values
 */

use yii\helpers\Html;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;
use function app\helpers\e;

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

$security_options = [
    'Any' => 'Any',
    'Anarchy' => 'Anarchy',
    'Lawless' => 'Lawless',
    'Low' => 'Low',
    'Medium' => 'Medium',
    'High' => 'High'
];

$population_options = [
    'Any' => 'Any',
    '10000000' => '>= 10Mil',
    '100000000' => '>= 100Mil',
    '1000000000' => '>= 1Bil',
    '10000000000' => '>= 10Bil',
    '20000000000' => '>= 20Bil',
];

$col2 = [
    'allegiance' => $allegiance_options,
    'economy' => $economy_options,
    'security' => $security_options
];

$labels_adv = $adv_form->attributeLabels();
$search_name_cls = !empty($errors) ? 'is-invalid' : null;
?>

<?= Html::beginForm(
    ['/systems/'],
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
            <div class="d-flex flex-column">
                <label for="population"><?= $labels_adv['population'] ?>:</label>
                <?= Html::dropDownList(
                    'population',
                    $adv_form_values['population'],
                    $population_options,
                    ['id' => 'population', 'class' => 'form-select form-select-sm mb-3']
                ) ?>
            </div>
        </div>
        <!-- end of form column 1 -->

        <!-- form column 2 -->
        <div class='col-6 col-sm w-100'>
            <?php foreach ($col2 as $key => $value) { ?>
                <div class="d-flex flex-column">
                    <label for="<?= $key ?>"><?= ucfirst($key) ?>:</label>
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