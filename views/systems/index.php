<?php

use app\models\forms\SystemsForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;

use function app\helpers\d;
use function app\helpers\e;

/** @var app\models\ar\Systems $model */
/** @var SystemsForm $form_model */
/** @var View $this */

$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, systems';
$this->title = 'Systems';
$this->params['breadcrumbs'] = [$this->title];

// $allegiance_options = [
//     'Alliance' => 'Alliance',
//     'Empire' => 'Empire',
//     'Federation' => 'Federation',
//     'Independent' => 'Independent',
//     'None' => 'None',
//     'Pirate' => 'Pirate',
//     'unknown' => 'unknown'
// ];

// $economy_options = [
//     'Agriculture' => 'Agriculture',
//     'Colony' => 'Colony',
//     'Damaged' => 'Damaged',
//     'Extraction' => 'Extraction',
//     'High Tech' => 'High Tech',
//     'Industrial' => 'Industrial',
//     'Military' => 'Military',
//     'None' => 'None',
//     'Prison' => 'Prison',
//     'Private Enterprise' => 'Private Enterprise',
//     'Refinery' => 'Refinery',
//     'Repair' => 'Repair',
//     'Rescue' => 'Rescue',
//     'Service' => 'Service',
//     'Terraforming' => 'Terraforming',
//     'Tourism' => 'Tourism',
//     'Engineering' => 'Engineering',
//     'unknown' => 'unknown'
// ];

// $security_options = [
//     'Anarchy' => 'Anarchy',
//     'Lawless' => 'Lawless',
//     'Low' => 'Low',
//     'Medium' => 'Anarchy',
//     'High' => 'High',
//     'unknown' => 'unknown',
// ];

// $population_options = [
//     '10000000' => '>= 10Mil',
//     '100000000' => '>= 100Mil',
//     '1000000000' => '>= 1Bil',
//     '10000000000' => '>= 10Bil',
//     '20000000000' => '>= 20Bil',
// ];

$error = $sys_name_form->getErrors();
$search_name_cls = !empty($error) ? 'is-invalid' : null;
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl px-2'>
        <div class='row'>
            <div class='col d-flex flex-column row-gap-3 mb-3 px-4'>
                <h1 class="mt-2 text-center sintony-bold"><?= $this->title ?></h1>

                <!-- 'search by name' form -->
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <?= Html::beginForm(
                            '/systems/',
                            'get',
                            [
                                'id' => 'sys-name-form',
                                'novalidate' => true,
                                'class' => [
                                    'fs-7',
                                    'bg-light',
                                    'rounded-2',
                                    'w-100',
                                    'px-1',
                                    'py-1'
                                ],
                            ]
                        ) ?>
                        <?= Html::label(
                            'Search by name:',
                            'sysName',
                            ['class' => ['text-nowrap', 'fs-6', 'fw-bold', 'align-content-center']]
                        ) ?>
                        <div class="d-flex gap-3">
                            <div class="w-75">
                                <?= Html::input('text', 'sysName', $sys_name_form->sysName, [
                                    'id' => 'sysName',
                                    'name' => 'sysName',
                                    'required' => true,
                                    'class' => [
                                        'form-control',
                                        'form-control-sm',
                                        'rounded-1',
                                        $search_name_cls !== 'is-invalid' ? 'border-dark-subtle' : null,
                                        'border-2',
                                        $search_name_cls
                                    ]
                                ]) ?>
                                <div class="invalid-feedback fw-bold">
                                    <?= $error['sysName'][0] ?? null ?>
                                </div>
                            </div>
                            <?= Html::button('search', [
                                'type' => 'submit',
                                'name' => 'sysNameBtn',
                                'class' => ['btn', 'btn-primary', 'btn-sm', 'text-uppercase', 'lett-spacing-2', 'w-25', 'align-self-start']
                            ]) ?>
                        </div>
                        <?= Html::endForm(); ?>
                    </div>
                </div>
                <!-- 'search by name' form -->

                <!-- accordion -->
                <div class="accordion accordion-flush border-dark-subtle bg-light mx-0" id="accordionForm">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne"
                                aria-expanded="true"
                                aria-controls="flush-collapseOne">
                                Accordion Item #1
                            </button>
                        </h2>
                        <div
                            id="flush-collapseOne"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionForm">
                            <div class="accordion-body">
                                This is the first item's accordion body.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end accordion -->

                <!-- nothing found -->
                <?php if (isset($systems) && empty($systems)) { ?>
                    <div class="rounded-1 bg-light text-center mx-auto px-3 py-2">
                        <p class="my-1 text-danger fw-bold text-uppercase lett-spacing-2">found nothing</p>
                    </div>
                <?php } ?>
                <!-- end of nothing found -->

                <!-- result for 'search by name' -->
                <?php if (!empty($systems)) { ?>
                    <div class="row justify-content-center row-gap-1">
                        <?php foreach ($systems as $key => $group) { ?>
                            <div style class="col-3">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($group as $k => $system) { ?>
                                        <li class="list-group-item bg-light">
                                            <?= e($system['name']); ?>
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