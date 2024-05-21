<?php

/**
 * @var string $ref_error
 * @var string $cargo_error
 * @var string $profit_error
 * @var string $targetSys
 * @var string $cargo
 * @var string $profit
 * @var string $pad_sizes
 * @var string $incl_surface
 * @var string $sort_options
 * @var string $max_dist_from_ref
 * @var string $max_dist_from_star
 * @var string $min_supply_demand
 * @var string $max_age_of_data
 * @var \app\models\forms\TradeRoutesForm $form_model
 */

use app\widgets\InputDropdown\InputDropdown;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$select_options = [
    'pad_sizes' =>  ['L' => 'L', 'M' => 'M', 'S' => 'S'], 'incl_surface' => ['No' => 'No', 'Yes' => 'Yes'],
    'sort_options' => ['Profit' => 'Profit', 'Updated_at' => 'Updated at (time)', 'Distance' => 'Distance (LY)'],
    'max_dist_from_ref' => ['Any' => 'Any', '25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '250' => '250 LY'],
    'max_dist_from_star' => [
        'Any' => 'Any',
        '100' => '100 ls',
        '500' => '500 ls',
        '1000' => '1000 ls',
        '2000' => '2000 ls',
    ],
    'min_supply_demand' => [
        'Any' => 'Any',
        '100' => '100',
        '500' => '500',
        '1000' => '1000',
        '2000' => '2000',
        '5000' => '5000',
        '10000' => '10000'
    ],
    'max_age_of_data' => ['Any' => 'Any', '1' => '1 hour', '4' => '4 hours', '10' => '10 hours', '24' => '1 day'],
];
extract($select_options);

$this->title = 'Trade routes';
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
                                <?= Html::beginForm(['/trade-routes/index'], 'get', [
                                    'id' => 'tr-form',
                                    'novalidate' => true,
                                    'class' => 'c-form fs-7 bg-light py-2 px-2 rounded-2 w-100 d-flex 
                                    flex-column needs-validation',
                                ]) ?>
                                <div class='container-xxl'>
                                    <div class='d-flex flex-column justify-content-between gap-4'>
                                        <div class='row justify-content-between'>
                                            <div class="col-lg-8 d-flex gap-3 flex-column">
                                                <!--form columns 1-2-->
                                                <div class="row justify-content-between">
                                                    <!--form column 1-->
                                                    <div class="col-lg-6 d-flex row-gap-3 flex-column">
                                                        <?= InputDropdown::widget([
                                                            'container' => 'tr-ref-idd',
                                                            'error' => $ref_error,
                                                            'selected' => $form_model->refSysStation,
                                                            'search' => 'ref-idd-search',
                                                            'to_submit' => 'ref-to-submit',
                                                            'placeholder' => 'Enter station name here',
                                                            'ajax' => true,
                                                            'endpoint' => '/system-station/',
                                                            'label_main' => 'Ref. station:',
                                                            'toggle_btn_text' => 'Get station list',
                                                            'name_main' => 'refSysStation',
                                                            'required' => 'required'
                                                        ]); ?>
                                                        <?= InputDropdown::widget([
                                                            'container' => 'tr-target-idd',
                                                            'selected' => $form_model->targetSysStation,
                                                            'search' => 'target-idd-search',
                                                            'to_submit' => 'target-to-submit',
                                                            'placeholder' => 'Enter station or system name here',
                                                            'ajax' => true,
                                                            'label_main' => '(optional) target',
                                                            'toggle_btn_text' => 'Get station / system list',
                                                            'name_main' => 'targetSysStation',
                                                            'radio_switch' => true,
                                                            'label_switch1' => 'system',
                                                            'label_switch2' => 'station',
                                                            'name_radio' => 'targetSysStationName',
                                                            'selected_radio' => $form_model->targetSysStationName,
                                                            'endpoint1' => '/system/',
                                                            'endpoint2' => '/system-station/',
                                                        ]); ?>
                                                        <div class="mt-2 mb-3">
                                                            <?= HTML::checkbox(
                                                                'roundTrip',
                                                                $form_model->roundTrip,
                                                                [
                                                                    'class' => ['form-check-input', 'fs-4'],
                                                                    'id' => 'round-trip',
                                                                    'name' => 'roundTrip'
                                                                ]
                                                            ) ?>
                                                            <label class="form-check-label py-2" for="round-trip">
                                                                Include round trips
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--form column 2-->
                                                    <div class="col-lg-6 d-flex gap-3 flex-column">
                                                        <div>
                                                            <label class="min-lett-spacing fw-bold
                                                    <?= $cargo_error === 'is-invalid' ? 'text-danger is-invalid' :
                                                                null ?>" for='cargo'>
                                                                Cargo capacity (t):
                                                            </label>
                                                            <?php
                                                            $cargo_profit_cls = [
                                                                'tr-text-input',
                                                                'form-control',
                                                                'border',
                                                                'rounded-2',
                                                                'shadow-none',
                                                                'py-1',
                                                                'fs-7',
                                                                'fw-normal'
                                                            ];
                                                            if ($cargo_error === 'is-invalid') {
                                                                HTML::addCssClass(
                                                                    $cargo_profit_cls,
                                                                    'is-invalid border-2 border-danger'
                                                                );
                                                            } else {
                                                                HTML::addCssClass($cargo_profit_cls, 'border-dark');
                                                            }

                                                            echo Html::textInput(
                                                                'cargo',
                                                                Html::encode($form_model->cargo),
                                                                [
                                                                    'class' => $cargo_profit_cls,
                                                                    'id' => 'cargo',
                                                                    'pattern' => "[0-9]+",
                                                                    'required' => ''
                                                                ]
                                                            ); ?>
                                                            <p class="invalid-feedback position-absolute mt-0 pt-0
                                                                        fw-bold">
                                                                Field must not be empty
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <label class="min-lett-spacing fw-bold
                                                    <?= $profit_error === 'is-invalid' ?
                                                                'text-danger is-invalid' : null ?>"
                                                                   for='profit'>
                                                                Min. profit per trip (Cr):
                                                            </label>
                                                            <?php
                                                            if ($cargo_error === 'is-invalid') {
                                                                HTML::addCssClass(
                                                                    $cargo_profit_cls,
                                                                    'is-invalid border-2 border-danger'
                                                                );
                                                            } else {
                                                                HTML::addCssClass($cargo_profit_cls, 'border-dark');
                                                            }

                                                            echo Html::textInput(
                                                                'profit',
                                                                Html::encode($form_model->profit),
                                                                [
                                                                    'class' => $cargo_profit_cls,
                                                                    'id' => 'profit',
                                                                    'pattern' => "[0-9]+",
                                                                    'required' => ''
                                                                ]
                                                            ); ?>
                                                            <p class="invalid-feedback position-absolute mt-0 pt-0
                                                                        fw-bold">
                                                                Field must not be empty
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class='min-lett-spacing fw-bold'
                                                                for='landingPadSize'>
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
                                                            <label
                                                                class='min-lett-spacing fw-bold'
                                                                for='includeSurface'>
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
                                            </div>
                                            <!--form column 3-->
                                            <div class="col-lg-4 d-flex gap-3 flex-column">
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
                                                    <label class='min-lett-spacing fw-bold' for='minSupplyDemand'>
                                                        Min. supply / demand:
                                                    </label>
                                                    <?= Html::dropDownList(
                                                        'minSupplyDemand',
                                                        $form_model->minSupplyDemand ?: '1000',
                                                        $min_supply_demand,
                                                        [
                                                            'class' => [
                                                                'form-select',
                                                                'form-select-sm',
                                                                'shadow-none',
                                                                'border-dark',
                                                                'fw-normal'
                                                            ],
                                                            'id' => 'minSupplyDemand'
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <!--submit button block-->
                                    <div class='row justify-content-center text-center'>
                                        <div class='col-md-3 pt-4 pb-2'>
                                            <button class='btn btn-violet fw-bold text-light text-uppercase mt-2 w-100'
                                                    type='submit' name='tr-form-submit'>
                                                Search
                                            </button>
                                        </div>
                                        <span class="fst-italic text-danger fs-7">
                                                    Note: carriers are not included
                                        </span>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="<?= !isset($model_error) ? 'd-none' : 'text-center mt-3' ?>">
            <span class="bg-light w-50 px-2 py-1 rounded-2 fs-5 text-danger ">
                <?= isset($model_error) ? $model_error : null ?>
            </span>
        </div>
    </div>
    
    <?= $result ?? null; ?>
</main>

