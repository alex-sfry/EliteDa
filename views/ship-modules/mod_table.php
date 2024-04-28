<?php

use yii\helpers\VarDumper;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

$table_head = [
    'Module',
    'Station',
    'Type',
    'Pad',
    'System',
    'Dist.(LY)',
    'Dist. to arr.(ls)',
    'Updated'
];

?>
<div class="c-result-legend bg-body text-center mt-3">
    <h2 class="fs-6 position-relative">Station's type:</h2>
    <div class="d-flex align-items-center py-1 ps-2 pe-1">
        <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 pe-1 align-items-center">
            <div class="c-result-legend-item-color bg-success h-100"></div>
            - surface
        </div>
        <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 align-items-center">
            <div class="c-result-legend-item-color bg-primary ms-2 h-100"></div>
            - space
        </div>
    </div>
</div>
<div class="c-pagination-cnt d-flex justify-content-center align-items-center my-0 flex-wrap">
    <?php
    if (isset($pagination)) {
        echo $page_count_info ?? null;
        echo LinkPager::widget([
            'id' => 'pgr01',
            'pagination' => $pagination,
            'disableCurrentPageButton' => false,
            'maxButtonCount' => 7,
            'firstPageLabel' => 'first',
            'lastPageLabel' => 'last',
            'prevPageCssClass' => 'prev-page',
            'nextPageCssClass' => 'next-page'
        ]);
    }
    ?>
</div>
<div id='c-table' class="rounded-2 table-responsive">
    <table class="mod-table fs-7 table table-striped mb-0 <?= count($models) > 0 ? 'overflow-x-auto' :
        'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($table_head as $item) : ?>
                    <?php echo match ($item) {
                        'Module' => "<th class='bg-light-orange p-0 text-body hover text-nowrap' scope='col'>
                            <a
                                href='$sort_module'
                                class='sort text-decoration-none d-block w-100 h-100 px-1 py-2 text-primary d-flex 
                                justify-content-between $module_sort'>
                                $item
                           </a>
                        </th>",
                        'Updated' =>
                        "<th class='bg-light-orange p-0 text-body text-nowrap' scope='col'>
                            <a
                                href='$sort_updated'
                                class='sort text-decoration-none d-block w-100 h-100 px-1 py-2 text-primary
                                d-flex justify-content-between $time_sort'>
                                $item
                            </a>
                        </th>",
                        'Dist.(LY)' =>
                        "<th class='bg-light-orange p-0 text-body text-nowrap' scope='col'>
                            <a
                                href='$sort_dist_ly'
                                class='sort text-decoration-none d-block w-100 h-100 px-1 py-2 text-primary
                                d-flex justify-content-between $d_ly_sort'>
                                $item
                            </a>
                        </th>",
                        default => "<th class='bg-light-orange text-body text-nowrap' scope='col' data-sort='asc'>
                                        $item
                                    </th>",
                    }; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($models as $item) : ?>
                <tr>
                    <td class="text-start text-truncate"><?= Html::encode($item['module']) ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['station']) ?></td>
                    <td class="sintony-bold text-start text-truncate
                    <?= $item['surface'] ? 'text-success' : 'text-primary' ?>"><?= Html::encode($item['type']) ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['pad']) ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['system']) ?></td>
                    <td class="text-start text-truncate"><?= (float)$item['distance_ly'] ?></td>
                    <td class="text-start text-truncate"><?= (int)$item['distance_ls'] ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['time_diff']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-light">
    <?php /* VarDumper::dump($models, 10, true); */ ?>
</div>
