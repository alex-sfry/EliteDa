<?php

/** @var yii\web\View $this */
/** @var array $errors */
/** @var array $form_values */
/** @var array $commodity_names */
/** @var CommoditiesForm $adv_form */
?>

<div class="mx-auto w-100">
    <div class="accordion" id="accordionForm">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button
                    class="accordion-button fw-bold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne">
                    Form
                </button>
            </h2>
            <div
                id="collapseOne"
                class="accordion-collapse collapse show"
                data-bs-parent="#accordionForm">
                <div class="accordion-body">

                    <!-- advanced form -->
                    <?= $this->render('_form', [
                        'form' => $form,
                        'form_values' => $form_values,
                        'commodity_names' => $commodity_names,
                        'errors' => $errors
                    ]) ?>
                    <!-- end of advanced form -->

                </div>
            </div>
        </div>
    </div>
</div>