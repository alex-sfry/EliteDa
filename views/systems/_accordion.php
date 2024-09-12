<div class="mx-auto w-100">
    <div class="accordion accordion-flush border-dark-subtle bg-light rounded-2" id="accordionForm">
        <div class="accordion-item w-100 rounded-2">
            <h2 class="accordion-header" id="flush-headingOne">
                <button
                    class="accordion-button collapsed rounded-2 fw-bold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne"
                    aria-expanded="true"
                    aria-controls="flush-collapseOne">
                    Advanced search
                </button>
            </h2>
            <div
                id="flush-collapseOne"
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