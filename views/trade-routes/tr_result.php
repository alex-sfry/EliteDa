<?php

use yii\bootstrap5\LinkPager;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var array $models
 * @var string|null $page_count_info
 * @var string $sort_price
 * @var string $sort_updated
 * @var string $sort_dist_ly
 * @var string $price_sort
 * @var string $time_sort
 * @var string $d_ly_sort
 * @var string $buy_sell_switch
 * @var int $station_id
 * @var int $system_id
 * @var Pagination|false $pagination
 */

?>
<div class="tr-result-wrapper container-xxl mt-4">
    <?php foreach ($models as $key => $value) : ?>
        <div class="tr-route d-flex flex-column row-gap-lg-1 row-gap-sm-2 border-2 border-dark  h-auto bg-light 
                    <?= $key !== 0 ? 'border-top' : null ?>
                    <?= $key !== count($models) - 1 ? 'border-bottom' : null ?>">
            <span class="fs-5 text-center">Route #<?= $key + 1 + $pagination->pageSize * $pagination->page ?></span>
            <div class="tr-route-block h-auto w-100 px-3 pb-3">
                <div class="tr-route-block-inner row justify-content-between my-0 mx-auto rounded-2">
                    <div class="tr-info-block col-lg-5 py-1 rounded-start-2">
                        <span class="fs-6 sintony-bold text-primary d-inline-block">Buy</span>
                        <span class="fst-italic sintony-bold ms-3"><?= $value['commodity'] ?></span>
                        <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                            <table class="table table-sm mb-1 mb-lg-0 table-borderless line">
                                <tbody>
                                    <tr>
                                        <td class="sintony-bold">Station:</td>
                                        <?php $source_station_id = (int)$source_station['station_id'] ?>
                                        <td class="text-end">
                                            <?= Html::a(
                                                $source_station['station'],
                                                Url::toRoute(["station/$source_station_id"]),
                                                ['class' => [
                                                    'table-link-tr text-decoration-underline 
                                                    link-underline-primary sintony-bold'
                                                ]]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Station type:</td>
                                        <td class="text-end"><?= $source_station['type'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Landing pad:</td>
                                        <td class="text-end"><?= $source_station['pad'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="sintony-bold">System:</td>
                                        <td class="text-end">
                                            <button 
                                                class="btn-copy btn btn-outline-secondary me-2"
                                                style="--bs-btn-padding-y: .06251rem; --bs-btn-padding-x: .5rem; 
                                                    --bs-btn-font-size: .75rem;">
                                                copy
                                            </button>
                                        <?php $source_system_id = (int)$source_station['system_id'] ?>
                                            <?= Html::a(
                                                $source_station['system'],
                                                Url::toRoute(["system/$source_system_id"]),
                                                ['class' => [
                                                    'table-link-tr text-decoration-underline 
                                                    sintony-bold ink-underline-primary'
                                                ]]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Distance from star:</td>
                                        <td class="text-end"><?= (int)$source_station['dta'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-sm mb-1 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Price:</td>
                                        <td class="text-end"><?= (int)$value['source_buy_price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Supply:</td>
                                        <td class="text-end"><?= (int)$value['source_stock']?></td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td class="text-end"><?= $value['source_time_diff'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-2 d-flex flex-lg-column justify-content-center bg-secondary-subtle">
                        <div class="arrow-cnt position-relative me-lg-0 me-5">
                            <div class="arrow arrow-right pt-lg-0 pt-2 ms-lg-0 ms-sm-5 ms-3">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="tr-info-block-mid text-lg-start text-sm-center ms-lg-0 ms-5 h-auto my-auto
                                        sintony-bold">
                            Profit per trip (Cr):
                            <span class="text-success sintony-bold"><?= (int)$value['profit'] ?></span>
                            <div class="w-100 bg-dark"></div>
                            Distance (LY):
                            <span class="text-primary sintony-bold"><?= (float)$value['distance'] ?></span>
                        </div>
                    </div>
                    <div class="tr-info-block tr-info-block-right col-lg-5 py-1 rounded-end-2">
                        <span class="fs-6 sintony-bold text-success d-inline-block">Sell</span>
                        <span class="fst-italic sintony-bold ms-3"><?=  $value['commodity'] ?></span>
                        <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                            <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="sintony-bold">Station:</td>
                                        <td class="text-end">
                                        <?php $target_station_id = (int)$value['target_station_id'] ?>
                                            <?= Html::a(
                                                $value['target_station'],
                                                Url::toRoute(["station/$target_station_id"]),
                                                ['class' => [
                                                    'table-link-tr text-decoration-underline 
                                                    sintony-bold link-underline-primary'
                                                ]]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Station type:</td>
                                        <td class="text-end"><?= $value['target_type'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Landing pad:</td>
                                        <td class="text-end"><?= $value['target_pad'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="sintony-bold">System:</td>
                                        <td class="text-end">
                                        <?php $target_system_id = (int)$value['target_system_id'] ?>
                                            <button 
                                                class="btn-copy btn btn-outline-secondary me-2"
                                                style="--bs-btn-padding-y: .06251rem; --bs-btn-padding-x: .5rem; 
                                                    --bs-btn-font-size: .75rem;">
                                                copy
                                            </button>
                                            <?= Html::a(
                                                $value['target_system'],
                                                Url::toRoute(["system/$target_system_id"]),
                                                ['class' => [
                                                    'table-link-tr text-decoration-underline 
                                                    sintony-bold link-underline-primary'
                                                ]]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Distance from star:</td>
                                        <td class="text-end"><?= (int)$value['target_dta'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-sm mb-1 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Price:</td>
                                        <td class="text-end"><?= (int)$value['target_sell_price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Demand:</td>
                                        <td class="text-end"><?= (int)$value['target_demand'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td class="text-end"><?= $value['target_time_diff'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($value['commodity_round'])) : ?>
                <div class="tr-route-block h-auto w-100 px-3 pb-3">
                    <div class="tr-route-block-inner row justify-content-between my-0 mx-auto rounded-2 ">
                        <div class="text-center mb-1">
                            <span class="sintony-bold text-violet">Return trip</span>
                        </div>
                        <div class="tr-info-block tr-info-block-left col-lg-5 py-1 rounded-start-2">
                            <span class="fs-6 sintony-bold text-success d-inline-block">Sell</span>
                            <span class="fst-italic sintony-bold ms-3">
                                <?= $value['commodity_round'] ?>
                            </span>
                            <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                                <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="sintony-bold">Station:</td>
                                            <td class="text-end">
                                                <?= Html::a(
                                                    $source_station['station'],
                                                    Url::toRoute(["station/$source_station_id"]),
                                                    ['class' => [
                                                        'table-link-tr text-decoration-underline sintony-bold
                                                        link-underline-primary'
                                                    ]]
                                                );?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Station type:</td>
                                            <td class="text-end"><?= $source_station['type'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Landing pad:</td>
                                            <td class="text-end"><?= $source_station['pad'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="sintony-bold">System:</td>
                                            <td class="text-end">
                                                <button 
                                                    class="btn-copy btn btn-outline-secondary me-2"
                                                    style="--bs-btn-padding-y: .06251rem; --bs-btn-padding-x: .5rem; 
                                                        --bs-btn-font-size: .75rem;">
                                                    copy
                                                </button>
                                                <?= Html::a(
                                                    $source_station['system'],
                                                    Url::toRoute(["system/$source_system_id"]),
                                                    ['class' => [
                                                        'table-link-tr text-decoration-underline 
                                                        sintony-bold link-underline-primary'
                                                    ]]
                                                );?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Distance from star:</td>
                                            <td class="text-end"><?= (int)$source_station['dta'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-sm mb-1 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Price:</td>
                                            <td class="text-end"><?= (int)$value['source_sell_price_round'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Demand:</td>
                                            <td class="text-end"><?= (int)$value['source_demand_round'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Updated:</td>
                                            <td class="text-end"><?= $value['source_time_diff'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex flex-lg-column justify-content-center bg-secondary-subtle">
                            <div class="arrow-cnt position-relative me-lg-0 me-5 pt-lg-0 mt-lg-0 pt-4 mt-3">
                                <div class="arrow arrow-left pt-lg-0 pt-2 ms-lg-0 ms-sm-5 ms-3">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <div class="tr-info-block-mid text-lg-start text-sm-center ms-lg-0 ms-5 h-auto my-auto
                                            sintony-bold">
                                Profit per trip (Cr):
                                <span class="text-success sintony-bold">
                                    <?= (int)$value['profit_round'] ?>
                                </span>
                                <div class="w-100 bg-dark"></div>
                                Distance (LY):
                                <span class="text-primary sintony-bold"><?= (float)$value['distance'] ?></span>
                            </div>
                        </div>
                        <div class="tr-info-block tr-info-block-right col-lg-5 py-1 order-lg-0 order-sm-2">
                            <span class="fs-6 sintony-bold text-primary d-inline-block">Buy</span>
                            <span class="fst-italic sintony-bold ms-3">
                                <?= $value['commodity_round'] ?>
                            </span>
                            <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                                <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Station:</td>
                                            <td class="text-end">
                                                <?= Html::a(
                                                    $value['target_station'],
                                                    Url::toRoute(["station/$target_station_id"]),
                                                    ['class' => [
                                                        'table-link-tr text-decoration-underline link-underline-primary'
                                                    ]]
                                                );?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Station type:</td>
                                            <td class="text-end"><?= $value['target_type'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Landing pad:</td>
                                            <td class="text-end"><?= $value['target_pad'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>System:</td>
                                            <td class="text-end">
                                                <button 
                                                    class="btn-copy btn btn-outline-secondary me-2"
                                                    style="--bs-btn-padding-y: .06251rem; --bs-btn-padding-x: .5rem; 
                                                        --bs-btn-font-size: .75rem;">
                                                    copy
                                                </button>
                                                <?= Html::a(
                                                    $value['target_system'],
                                                    Url::toRoute(["system/$target_system_id"]),
                                                    ['class' => [
                                                        'table-link-tr text-decoration-underline link-underline-primary'
                                                    ]]
                                                );?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Distance from star:</td>
                                            <td class="text-end"><?= (int)$value['target_dta'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-sm mb-1 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Price:</td>
                                            <td class="text-end"><?= (int)$value['target_buy_price_round'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supply:</td>
                                            <td class="text-end"><?= (int)$value['target_stock_round'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Updated:</td>
                                            <td class="text-end"><?=  $value['target_time_diff'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <div class="c-pagination-cnt d-flex justify-content-center align-items-center mt-2 mb-3 flex-wrap">
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
                'nextPageCssClass' => 'next-page',
            ]);
        }
        ?>
    </div>
</div>
