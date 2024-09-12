<?php

use app\assets\TSelectAsset;
use app\models\forms\SystemsAdvancedForm;
use app\models\forms\SystemsNameForm;
use yii\web\View;

use function app\helpers\d;
use function app\helpers\e;

/** @var app\models\ar\Systems $model */
/** @var SystemsNameForm $by_name_form */
/** @var SystemsAdvancedForm $adv_form */
/** @var View $this */

TSelectAsset::register($this);
$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, systems';
$this->title = 'Systems';
$this->params['breadcrumbs'] = [$this->title];
$formatter = \Yii::$app->formatter;
$formatter->decimalSeparator = ' ';
// d($models);
$c++;
echo $c;
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

                        <!-- nothing found -->
                        <?php if (isset($models) && empty($models)) { ?>
                            <div class="rounded-1 bg-light text-center mx-auto px-3 py-2">
                                <p class="my-1 text-danger fw-bold text-uppercase lett-spacing-2">found nothing</p>
                            </div>
                        <?php } ?>
                        <!-- end of nothing found -->

                    </div>
                </div>

                <!-- result for 'search by name' -->
                <?php if (!empty($models)) { ?>
                    <div class="row justify-content-center row-gap-1">
                        <?php foreach ($models as $key => $group) { ?>
                            <div style class="col-3">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($group as $k => $system) { ?>
                                        <li class="list-group-item bg-light">
                                            <?= e($system['name']) . '<br>' ?>
                                            <?= $formatter->asInteger(e($system['population'])) . '<br>' ?>
                                            <?= e($system['allegiance']['faction_name']) . '<br>' ?>
                                            <?= e($system['economy']['economy_name']) . '<br>' ?>
                                            <?= e($system['security']['security_level']) . '<br>' ?>
                                            <?= isset($system['distance']) ? e($system['distance']) : null ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!-- end of result for 'search by name' -->

            </div>
        </div>
    </div>
</main>