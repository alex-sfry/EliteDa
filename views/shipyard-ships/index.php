<?php

/** @var View $this */
/** @var array $models */
/** @var array $form_values */
/** @var ShipyardShipsForm $form */

use app\assets\TSelectAsset;
use app\widgets\InputDropdown\InputDropdown;
use yii\helpers\Html;

use function app\helpers\d;
use function app\helpers\e;

$pad_sizes = ['L' => 'L', 'M' => 'M', 'S' => 'S'];
$incl_surface = ['No' => 'No', 'Yes' => 'Yes(w/o Odyssey)', 'Odyssey' => 'Yes(w/ Odyssey)'];
$max_dist_from_ref = ['Any' => 'Any', '25' => '25 LY', '50' => '50 LY', '100' => '100 LY', '150' => '150 LY'];
$max_dist_from_star = [
    'Any' => 'Any',
    '100' => '100 ls',
    '500' => '500 ls',
    '1000' => '1000 ls',
    '2000' => '2000 ls',
];
$max_age_of_data = ['Any' => 'Any', '1' => '1 hour', '4' => '4 hours', '10' => '10 hours', '24' => '1 day'];

TSelectAsset::register($this);
$this->params['meta_keywords'] = 'Elite: Dangerous, shipyard, ships';
$this->title = 'Ships';
$this->params['breadcrumbs'] = [$this->title];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl px-2'>
        <div class='row'>
            <div class='col d-flex flex-column row-gap-3 mb-3 px-4'>
                <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
                <div class='row justify-content-center'>
                    <div class="col-sm-9 col-lg-6 d-flex flex-column row-gap-3">

                        <!-- accordion -->
                        <?= $this->render('_accordion', [
                            'form' => $form,
                            'form_values' => $form_values,
                            'ship_names' => $ship_names,
                            'errors' => $form->getErrors()
                        ]) ?>
                        <!-- end accordion -->

                    </div>
                </div>

                <!-- loader container -->
                <div class='loader-cnt row justify-content-center d-none'></div>
                <!-- end of loader container -->

                <!-- result -->
                <?php if (!empty($models)) { ?>
                    <?= $this->render(
                        '_search_result',
                        ['models' => $models, 'name' => $ship_names[$form_values['cMainSelect']]]
                    ); ?>
                <?php } elseif (isset($models) && empty($models)) { ?>
                    <div class="rounded-1 bg-light text-center mx-auto px-3 py-2">
                        <p class="my-1 text-danger fw-bold text-uppercase lett-spacing-2">found nothing</p>
                    </div>
                <?php } ?>
                <!-- end of result -->

            </div>
        </div>
    </div>
</main>