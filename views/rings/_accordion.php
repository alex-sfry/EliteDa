<?php

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
<?= $this->render('_form', ['form_model' => $form_model, 'ref_error' => $ref_error]) ?>
<!-- end of form -->

            </div>
        </div>
    </div>
</div>