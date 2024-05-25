<?php

/**
 * @var string $ref_error
 * @var string $cargo_error
 * @var string $cargo
 * @var string $pad_sizes
 * @var string $incl_surface
 * @var string $sort_options
 * @var string $max_dist_from_ref
 * @var string $max_dist_from_star
 * @var string $max_age_of_data
 * @var \app\models\forms\ShipModulesForm $form_model
 */

use app\widgets\CustomSelect\CustomSelect;
use app\widgets\InputDropdown\InputDropdown;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$select_options = [
    'pad_sizes' =>  ['L' => 'L', 'M' => 'M', 'S' => 'S'], 'incl_surface' => ['No' => 'No', 'Yes' => 'Yes'],
    'sort_options' => ['Module' => 'Module', 'Updated_at' => 'Updated at (time)', 'Distance' => 'Distance (LY)'],
    'max_dist_from_ref' => ['Any' => 'Any', '25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '250' => '250 LY'],
    'max_dist_from_star' => [
        'Any' => 'Any',
        '100' => '100 ls',
        '500' => '500 ls',
        '1000' => '1000 ls',
        '2000' => '2000 ls',
    ],
    'max_age_of_data' => ['Any' => 'Any', '1' => '1 hour', '4' => '4 hours', '10' => '10 hours', '24' => '1 day'],
];
extract($select_options);

$this->title = 'Ship modules';
$this->params['breadcrumbs'] = [$this->title];
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3 d-flex'>
            <div class='d-flex flex-column w-100 gap-3'>
                <h1 class='mt-2 text-center fs-2 text-custom-orange sintony-bold'><?= Html::encode($this->title) ?></h1>
                <div class="accordion" id="accordionForm">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button fw-bold <?= isset($result) ? 'collapsed' : '' ?>"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseOne"
                                aria-expanded="<?= !isset($result) ? 'true' : 'false' ?>"
                                aria-controls="collapseOne">
                                <?= !isset($result) ? 'Close form' : 'Open form' ?>
                            </button>
                        </h2>
                        <div
                            id="collapseOne"
                            class="accordion-collapse collapse <?= !isset($result) ? 'show' : '' ?>"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?= Html::beginForm(['/ship-modules/index'], 'get', [
                                    'id' => 'mod-form',
                                    'novalidate' => true,
                                    'class' => 'c-form fs-7 bg-light py-2 px-2 rounded-2 w-100 d-flex 
                                    flex-column needs-validation',
                                ]) ?>
                                <div class='container-xxl'>
                                    <div class='d-flex flex-column justify-content-between gap-4'>
                                        <div class='row row-gap-3 justify-content-between'>
                                            <!--form column 1-->
                                            <div class='min-lett-spacing col-lg-4 row-gap-3'>
                                                <?= CustomSelect::widget([
                                                    'container' => 'c-custom-select',
                                                    'error' => $mod_error,
                                                    'selected' => $form_model->cMainSelect,
                                                    'search' => 'c-select-search',
                                                    'to_submit' => 'c-hiddenSelect',
                                                    'placeholder' => 'selected modules',
                                                    'label_main' => 'Modules:',
                                                    'toggle_btn_text' => 'Select modules',
                                                    'name_main' => 'cMainSelect[]',
                                                    'list_items' => $ship_modules_arr,
                                                    'required' => 'required',
                                                    'filter_method' => 'includes',
                                                ]); ?>
                                            </div>
                                            <!--form column 2-->
                                            <div class="col-lg-4 d-flex row-gap-3 flex-column">
                                                <div>
                                                    <?= InputDropdown::widget([
                                                        'container' => 'c-ref-idd',
                                                        'error' => $ref_error,
                                                        'selected' => $form_model->refSystem,
                                                        'search' => 'ref-idd-search',
                                                        'to_submit' => 'ref-to-submit',
                                                        'placeholder' => 'Enter system name here',
                                                        'ajax' => true,
                                                        'endpoint' => '/system/get/',
                                                        'label_main' => 'Ref. system:',
                                                        'toggle_btn_text' => 'Get system list',
                                                        'name_main' => 'refSystem',
                                                        'required' => 'required'
                                                    ]); ?>
                                                </div>
                                                <div style="<?= $form_model->refSystem ?
                                                                'margin-top: 10px' : 'margin-top: 33px' ?>">
                                                    <label class='min-lett-spacing fw-bold' for='landingPadSize'>
                                                        Min. landing pad size:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'landingPadSize',
                                                        $form_model->landingPadSize,
                                                        $pad_sizes,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'landingPadSize'
                                                        ]
                                                    ) ?>
                                                </div>
                                                <div>
                                                    <label class='min-lett-spacing fw-bold' for='includeSurface'>
                                                        Include surface:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'includeSurface',
                                                        $form_model->includeSurface,
                                                        $incl_surface,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'includeSurface'
                                                        ]
                                                    ) ?>
                                                </div>
                                            </div>
                                            <!--form column 3-->
                                            <div class="col-lg-4 d-flex row-gap-3 flex-column">
                                                <div>
                                                    <label
                                                        class='min-lett-spacing fw-bold'
                                                        for='maxDistanceFromRefStar'>
                                                        Max. distance from ref. system:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'maxDistanceFromRefStar',
                                                        $form_model->maxDistanceFromRefStar ?: '50',
                                                        $max_dist_from_ref,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'maxDistanceFromRefStar'
                                                        ]
                                                    ) ?>
                                                </div>
                                                <div>
                                                    <label class='min-lett-spacing fw-bold' for='distanceFromStar'>
                                                        Max. distance from the star:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'distanceFromStar',
                                                        $form_model->distanceFromStar ?: '500',
                                                        $max_dist_from_star,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'distanceFromStar'
                                                        ]
                                                    ) ?>
                                                </div>
                                                <div>
                                                    <label class='min-lett-spacing fw-bold' for='dataAge'>
                                                        Max. age of data:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'dataAge',
                                                        $form_model->dataAge ?: 'Any',
                                                        $max_age_of_data,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'dataAge'
                                                        ]
                                                    ) ?>
                                                </div>
                                                <div>
                                                    <label class='min-lett-spacing fw-bold' for='sortBy'>
                                                        Sort by:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'sortBy',
                                                        $form_model->sortBy,
                                                        $sort_options,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'sortBy'
                                                        ]
                                                    ) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!--submit block-->
                                            <div class='row justify-content-center text-center'>
                                                <div class='col-md-3 pt-4 pb-2'>
                                                    <button
                                                        class='btn btn-violet fw-bold text-light text-uppercase mt-2
                                                 w-100'
                                                        type='submit'
                                                        name='c-form-submit'>
                                                        Search
                                                    </button>
                                                </div>
                                                <span class="fst-italic text-danger fs-7">
                                                    Note: carriers are not included
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $result ?? null; ?>
            </div>
        </div>
    </div>
</main>