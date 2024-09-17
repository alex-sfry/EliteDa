<?php

use app\widgets\TableJs\TableJs;

use function app\helpers\d;
use function app\helpers\ksq;

$this->params['meta_keywords'] =
    'Elite: Dangerous, galaxy information, station ships, station shipyard, ships, shipyard';
$this->title = $station_name . ' station shipyard';
$this->params['breadcrumbs'] = [
    [
        'label' => $station_name,
        'url' => ['stations/details', 'id' => $id],
    ],
    $this->title
];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row">
            <div class="col mb-3">
                <h1 class='mt-3 text-center fs-2 sintony-bold'>
                    <?= $this->title ?>
                </h1>
                <div class="text-light row flex-column flex-md-row fs-7 justify-content-md-center row-gap-2">
                    <div class="max-w-f-content mx-auto mx-md-0">
                        <div class="d-flex flex-row flex-md-column gap-2 justify-content-md-center align-content-center justify-content-lg-start mt-2">

                            <!-- services side bar -->
                            <?= $this->render('_services', [
                                'id' => $id,
                                'services' => $services,
                                'active' => 'ships'
                            ]) ?>
                            <!-- services side bar -->

                        </div>
                    </div>
                    <div class="bg-light rounded-2 px-2 bg-transparent text-center mx-auto mx-md-0
                                col col-sm-11 col-md-9 col-lg-8 col-xl-6">
                        <?php echo TableJs::widget([
                            'container' => 'w-table',
                            'model' => $models,
                            'default_sorting' => 'asc',
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'label' => 'Ship',
                                    'filterInputOptions' => [
                                        'class' => 'form-control',
                                    ],
                                    'req_url' => 'req_url'
                                ],
                                [
                                    'attribute' => 'price',
                                    'label' => 'Price',
                                    'textAfter' => ' Cr',
                                    'sort' => false,
                                    'format' => 'integer'
                                ],
                                [
                                    'attribute' => 'timestamp',
                                    'label' => 'Updated',
                                    'sort' => false
                                ],
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>