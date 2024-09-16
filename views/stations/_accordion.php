<?php

/** @var View $this */
/** @var array $errors */
/** @var array $adv_form_values */
/** @var StationsAdvancedForm $by_name_form */
?>

<div class="mx-auto w-100">
    <div class="accordion" id="accordionForm">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button
                    class="accordion-button collapsed fw-bold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne">
                    Advanced search
                </button>
            </h2>
            <div
                id="collapseOne"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionForm">
                <div class="accordion-body">
                    <!-- advanced form -->
                    <?= $this->render('_adv_form', [
                        'adv_form' => $adv_form,
                        'adv_form_values' => $adv_form_values,
                        'errors' => $errors
                    ]) ?>
                    <!-- end of advanced form -->

                </div>
            </div>
        </div>
    </div>
</div>