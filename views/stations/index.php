<?php

use app\assets\TSelectAsset;
use yii\web\View;

use function app\helpers\d;
use function app\helpers\e;

/** @var View $this */
/** @var array $models */
/** @var array $by_name_form_values */
/** @var array $adv_form_values */
/** @var StationsAdvancedForm $adv_form */
/** @var StationsNameForm $by_name_form */

TSelectAsset::register($this);
$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, stations';
$this->title = 'Stations';
$this->params['breadcrumbs'] = [$this->title];
// d($models);
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl px-2'>
        <div class='row'>
            <div class='col d-flex flex-column row-gap-3 mb-3 px-4'>
                <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>
                <div class='row justify-content-center'>
                    <div class="col-sm-9 col-lg-6 d-flex flex-column row-gap-3">

                        <!-- 'search by name' form -->
                        <?= $this->render('_search_by_name_form', [
                            'by_name_form_values' => $by_name_form_values,
                            'errors' => $by_name_form->getErrors()
                        ]) ?>
                        <!-- 'search by name' form -->

                        <!-- accordion -->
                        <?= $this->render('_accordion', [
                            'adv_form' => $adv_form,
                            'adv_form_values' => $adv_form_values,
                            'errors' => $adv_form->getErrors()
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
                        ['models' => $models, 'population' => $adv_form_values['population']]
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