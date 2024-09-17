<?php

/** @var View $this */
/** @var array $models */
/** @var array $form_values */
/** @var array $module_names */
/** @var ShipModulesForm $form */

use app\assets\TSelectAsset;

use function app\helpers\d;
use function app\helpers\e;

TSelectAsset::register($this);
$this->params['meta_keywords'] = 'Elite: Dangerous, outfitting, modules';
$this->title = 'Ship modules';
$this->params['breadcrumbs'] = [$this->title];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl px-2'>
        <div class='row'>
            <div class='col d-flex flex-column row-gap-3 mb-3 px-4'>
                <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
                <div class='row justify-content-center'>
                    <div class="col-md col-lg-9 d-flex flex-column row-gap-3">

                        <!-- accordion -->
                        <?= $this->render('_accordion', [
                            'form' => $form,
                            'form_values' => $form_values,
                            'module_names' => $module_names,
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
                    <?= $this->render('_search_result', ['models' => $models, 'module_names' => $module_names]); ?>
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