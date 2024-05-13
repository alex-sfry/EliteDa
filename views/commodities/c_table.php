<?php

/**
 * @var array $models
 * @var string|null $page_count_info
 * @var string $pager
 * @var array $get
 * @var string $sort_price
 * @var string $sort_updated
 * @var string $sort_dist_ly
 * @var string $price_sort
 * @var string $time_sort
 * @var string $d_ly_sort
 * @var \yii\data\Pagination $pagination
 */

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$table_head = [
    'Commodity',
    'Station',
    'Type',
    'Pad',
    'System',
    'Dist.(LY)',
    'Dist. to arr.(ls)',
    $get['buySellSwitch'] === 'buy' ? 'Supply' : 'Demand',
    'Price',
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
<div id='c-table' class="rounded-2 table-responsive">
    <table class="c-table fs-7 table table-striped mb-0 <?= count($models) > 0 ? 'overflow-x-auto' :
        'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($table_head as $item) : ?>
                    <?php echo match ($item) {
                        'Price' => "<th class='bg-light-orange p-0 text-body hover text-nowrap' scope='col'>
                            <a
                                href='$sort_price'
                                class='sort text-decoration-none w-100 h-100 px-1 py-2 text-primary d-flex 
                                justify-content-between align-items-center $price_sort'>
                                $item
                           </a>
                        </th>",
                        'Updated' =>
                        "<th class='bg-light-orange p-0 text-body text-nowrap' scope='col'>
                            <a
                                href='$sort_updated'
                                class='sort text-decoration-none w-100 h-100 px-1 py-2 text-primary
                                d-flex justify-content-between align-items-center $time_sort'>
                                $item
                            </a>
                        </th>",
                        'Dist.(LY)' =>
                        "<th class='bg-light-orange p-0 text-body text-nowrap' scope='col'>
                            <a
                                href='$sort_dist_ly'
                                class='sort text-decoration-none w-100 h-100 px-1 py-2 text-primary
                                d-flex justify-content-between align-items-center $d_ly_sort'>
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
                    <td class="text-start text-truncate"><?= Html::encode($item['commodity']) ?></td>
                    <td class="table-link text-start text-truncate text-decoration-underline link-underline-primary">
                        <?= Html::a(
                            Html::encode($item['station']),
                            Url::toRoute(["stations/details/{$item['station_id']}"])
                        );?>
                    </td>
                    <td class="sintony-bold text-start text-truncate
                    <?= $item['surface'] ? 'text-success' : 'text-primary' ?>"><?= Html::encode($item['type']) ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['pad']) ?></td>
                    <td class="text-start text-truncate"><?= Html::encode($item['system']) ?></td>
                    <td class="text-start text-truncate"><?= (float)$item['distance_ly'] ?></td>
                    <td class="text-start text-truncate"><?= (int)$item['distance_ls'] ?></td>
                    <td class="text-start text-truncate"><?= isset($item['stock'])  ?
                            (int)$item['stock'] : (int)$item['demand'] ?></td>
                    <td class="sintony-bold text-start text-truncate text-success">
                        <?= isset($item['sell_price'])  ? (int)$item['sell_price'] : (int)$item['buy_price'] ?> Cr
                    </td>
                    <td class="text-start text-truncate"><?= Html::encode($item['time_diff']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="c-pagination-cnt d-flex justify-content-center align-items-center pb-4">
    <?php
    echo $page_count_info ?? null;
    echo LinkPager::widget([
        'id' => 'pgr02',
        'pagination' => $pagination,
        'disableCurrentPageButton' => false,
        'maxButtonCount' => 7,
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'prevPageCssClass' => 'prev-page',
        'nextPageCssClass' => 'next-page'
    ]);
    ?>
</div>
