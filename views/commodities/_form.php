<?php

/** @var yii\web\View $this */
/** @var array $errors */
/** @var array $form_values */
/** @var array $commodity_names */
/** @var CommoditiesForm $form */

use yii\helpers\Html;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;
use function app\helpers\e;

$pad_sizes = ['L' => 'L', 'M' => 'M', 'S' => 'S'];
$incl_surface = ['No' => 'No', 'Yes' => 'Yes(w/o Odyssey)', 'Odyssey' => 'Yes(w/ Odyssey)'];
$sort_options = ['Price' => 'Price', 'Updated_at' => 'Updated at (time)', 'Distance' => 'Distance (LY)'];
// $max_dist_from_ref = ['Any' => 'Any', '25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '250' => '250 LY'];
$max_dist_from_star = [
    'Any' => 'Any',
    '100' => '100 ls',
    '500' => '500 ls',
    '1000' => '1000 ls',
    '2000' => '2000 ls',
];
$min_supply_demand = [
    'Any' => 'Any',
    '100' => '100',
    '500' => '500',
    '1000' => '1000',
    '2000' => '2000',
    '5000' => '5000',
    '10000' => '10000'
];
$max_age_of_data = ['Any' => 'Any', '1' => '1 hour', '4' => '4 hours', '10' => '10 hours', '24' => '1 day'];

$col1 = [
    'landingPadSize' => $pad_sizes,
    'includeSurface' => $incl_surface,
];

$col2 = [
    'distanceFromStar' => $max_dist_from_star,
    'minSupplyDemand' => $min_supply_demand,
    'dataAge' => $max_age_of_data,
    'sortBy' => $sort_options
];

$labels = $form->attributeLabels();
$search_name_cls = isset($errors['refSystem']) ? 'is-invalid' : null;
$search_mod_cls = isset($errors['cMainSelect']) ? 'is-invalid' : null;
// d($commodity_names);
?>

<?= Html::beginForm(
    ['/commodities/'],
    'get',
    [
        'id' => 'adv-commodities-form',
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
        <div class='col-md-6'>
            <div class="d-flex flex-column">
                <label class="tselect-lbl-2" for="cMainSelect"><?= $labels['cMainSelect'] ?>:</label>
                <select
                    class="t-sel form-select form-select-sm mb-3 <?= $search_mod_cls ?>"
                    name="cMainSelect[]"
                    id="cMainSelect"
                    placeholder="Select commodities..."
                    aria-describedby="inputGroupPrepend3 validationServerCMainSelectFeedback"
                    multiple
                    required>
                    <?php foreach ($commodity_names as $key => $value) { ?>
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
            <?php foreach ($col1 as $key => $value) { ?>
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
        <!-- end of form column 1 -->

        <!-- form column 2 -->
        <div class='col-md-6'>
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

    <!--buy/sell switch-->
    <div class='buy-sell-switch ol-xl-2 d-flex text-center justify-content-center w-100 align-content-center gap-3'>
        <div class=" text-end">
            <input
                class='btn-check'
                type='radio'
                id='buy-toggle'
                name='buySellSwitch'
                value='buy_price'
                autocomplete='off'
                checked>
            <label class='btn p-1 border-0' for='buy-toggle'>
                i want to buy
            </label>
        </div>
        <div class=" text-end">
            <input
                class='btn-check'
                type='radio'
                id='sell-toggle'
                name='buySellSwitch'
                value='sell_price'
                autocomplete='off'
                <?= $form_values['buySellSwitch'] === 'sell_price' ? 'checked' : '' ?>>
            <label class='btn p-1 border-0' for='sell-toggle'>
                i want to sell
            </label>
        </div>
    </div>
    <!--end of buy/sell switch-->
    <div class="mt-4 d-flex col-sm-6 col-md-6 col-lg-5 justify-content-center align-self-center">
        <button
            class='btn btn-sm btn-primary w-100 fw-bold text-uppercase'
            type='submit'
            name='formBtn'>
            Search
        </button>
    </div>
</div>