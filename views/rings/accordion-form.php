<?php

use app\widgets\InputDropdown\InputDropdown;
use yii\helpers\Html;

use function app\helpers\e;

$type = ['Icy' => 'Icy', 'Metal Rich' => 'Metal Rich', 'Metallic' => 'Metallic', 'Rocky' => 'Rocky'];
$maxDistanceFromRefStar = ['25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '150' => '150 LY'];
$distanceFromStar = ['Any' => 'Any', '100' => '100 ls', '500' => '500 ls', '1000' => '1000 ls', '2000' => '2000 ls'];
$sortBy = ['DistanceLy' => 'Distance (LY)', 'DistanceLs' => 'Distance (ls)'];
$selects = ['type', 'maxDistanceFromRefStar', 'distanceFromStar', 'sortBy'];
?>

<div class="accordion" id="accordionForm">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button
                class="accordion-button fw-bold 
                <?= isset($models) && !empty($models) ? 'collapsed' : ''; ?>"
                type=" button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseOne"
                aria-expanded="<?= !isset($models) || empty($models) ? 'true' : 'false'; ?>"
                aria-controls="collapseOne">
                <?= !isset($models) || empty($models) ? 'Close form' : 'Open form'; ?>
            </button>
        </h2>
        <div
            id="collapseOne"
            class="accordion-collapse collapse 
            <?= !isset($models) || empty($models) ? 'show' : ''; ?>"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">

                <!-- form -->
                <?= Html::beginForm(['/rings/index'], 'get', [
                    'id' => 'rings-form',
                    'novalidate' => true,
                    'class' => 'c-form fs-7 bg-light py-1 rounded-2 w-100 d-flex flex-column 
                                needs-validation',
                ]) ?>
                <div class='container-xxl'>
                    <div class="row justify-content-center">
                        <div class='d-flex flex-column justify-content-between gap-4'>
                            <div class='row justify-content-between'>
                                <div class='min-lett-spacing col-md-6'>
                                    <div>
                                        <?= InputDropdown::widget([
                                            'container' => 'c-ref-idd',
                                            'error' => $ref_error,
                                            'selected' => e($form_model->refSystem),
                                            'search' => 'ref-idd-search',
                                            'to_submit' => 'ref-to-submit',
                                            'placeholder' => 'Enter system name here',
                                            'ajax' => true,
                                            'endpoint' => '/system/get/',
                                            'label_main' => 'Ref. system:',
                                            'toggle_btn_text' => 'Get system list',
                                            'name_main' => 'refSystem',
                                            'required' => 'required'
                                        ]) ?>
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
                                                    'class' => 'form-select form-select-sm shadow-none border-dark 
                                                                w-100',
                                                    'id' => $elem
                                                ]
                                            ) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div
                            class="mt-3 mb-1 d-flex col-sm-6 col-md-6 col-lg-5 
                                justify-content-center">
                            <button
                                class='btn btn-sm btn-primary w-100 fw-bold text-uppercase mt-4 mb-1 outl'
                                type='submit'
                                name='c-form-submit'>
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <?php Html::endForm() ?>
                <!-- end of form -->

            </div>
        </div>
    </div>
</div>