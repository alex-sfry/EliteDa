<?php

/** @var array $models */

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

?>
<div class="bg-light">
    <?php /* d($models[0]) */ ?>
</div>
<div class="tr-result-wrapper container-xxl mt-4">
    <?php foreach ($models as $key => $value) : ?>
        <div class="tr-route d-flex flex-column row-gap-lg-1 row-gap-sm-2 border border-2 border-light-orange h-auto
                        bg-light">
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
                                        <td>Station:</td>
                                        <?php $source_station_id = Html::encode($value['source']['station_id']) ?>
                                        <td class="text-end table-link-tr">
                                            <?= Html::a(
                                                Html::encode($value['source']['station']),
                                                Url::toRoute(["station/$source_station_id"]),
                                                ['class' => ['text-decoration-underline', 'link-underline-primary']]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Station type:</td>
                                        <td class="text-end"><?= $value['source']['type']?></td>
                                    </tr>
                                    <tr>
                                        <td>Landing pad:</td>
                                        <td class="text-end"><?= $value['source']['pad'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>System:</td>
                                        <td class="text-end"><?= $value['source']['system'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Distance from star:</td>
                                        <td class="text-end"><?= $value['source']['distance_ls'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-sm mb-1 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Price:</td>
                                        <td class="text-end"><?= $value['source']['buy_price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Supply:</td>
                                        <td class="text-end"><?= $value['source']['stock'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td class="text-end"><?= $value['source']['time_diff'] ?></td>
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
                            <span class="text-success sintony-bold"><?= $value['dir_profit'] ?></span>
                            <div class="w-100 bg-dark"></div>
                            Distance (LY):
                            <span class="text-info sintony-bold"><?= $value['distance_ly'] ?></span>
                        </div>
                    </div>
                    <div class="tr-info-block tr-info-block-right col-lg-5 py-1 rounded-end-2">
                        <span class="fs-6 sintony-bold text-success d-inline-block">Sell</span>
                        <span class="fst-italic sintony-bold ms-3"><?= $value['commodity'] ?></span>
                        <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                            <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Station:</td>
                                        <?php $target_station_id = Html::encode($value['target']['station_id']) ?>
                                        <td class="text-end table-link-tr">
                                            <?= Html::a(
                                                Html::encode($value['target']['station']),
                                                Url::toRoute(["station/$target_station_id"]),
                                                ['class' => ['text-decoration-underline', 'link-underline-primary']]
                                            );?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Station type:</td>
                                        <td class="text-end"><?= $value['target']['type']?></td>
                                    </tr>
                                    <tr>
                                        <td>Landing pad:</td>
                                        <td class="text-end"><?= $value['target']['pad'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>System:</td>
                                        <td class="text-end"><?= $value['target']['system'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Distance from star:</td>
                                        <td class="text-end"><?= $value['target']['distance_ls'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-sm mb-1 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Price:</td>
                                        <td class="text-end"><?= $value['target']['sell_price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Demand:</td>
                                        <td class="text-end"><?= $value['target']['demand'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td class="text-end"><?= $value['target']['time_diff'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($value['round_trip']) : ?>
                <div class="tr-route-block h-auto w-100 px-3 pb-3">
                    <div class="tr-route-block-inner row justify-content-between my-0 mx-auto rounded-2 ">
                        <div class="text-center mb-1">
                            <span class="fst-italic sintony-bold text-info">Return trip</span>
                        </div>
                        <div class="tr-info-block tr-info-block-left col-lg-5 py-1 rounded-start-2">
                            <span class="fs-6 sintony-bold text-success d-inline-block">Sell</span>
                            <span class="fst-italic sintony-bold ms-3"><?= $value['round_commodity'] ?></span>
                            <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                                <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Station:</td>
                                            <td class="text-end"><?= $value['source']['station'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Station type:</td>
                                            <td class="text-end"><?= $value['source']['type']?></td>
                                        </tr>
                                        <tr>
                                            <td>Landing pad:</td>
                                            <td class="text-end"><?= $value['source']['pad'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>System:</td>
                                            <td class="text-end"><?= $value['source']['system'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Distance from star:</td>
                                            <td class="text-end"><?= $value['source']['distance_ls'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-sm mb-1 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Price:</td>
                                            <td class="text-end"><?= $value['source']['sell_price'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Demand:</td>
                                            <td class="text-end"><?= $value['source']['demand'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Updated:</td>
                                            <td class="text-end"><?= $value['source']['time_diff'] ?></td>
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
                                <span class="text-success sintony-bold"><?= $value['round_profit'] ?></span>
                                <div class="w-100 bg-dark"></div>
                                Distance (LY):
                                <span class="text-info sintony-bold"><?= $value['distance_ly'] ?></span>
                            </div>
                        </div>
                        <div class="tr-info-block tr-info-block-right col-lg-5 py-1 order-lg-0 order-sm-2">
                            <span class="fs-6 sintony-bold text-primary d-inline-block">Buy</span>
                            <span class="fst-italic sintony-bold ms-3">Advanced Catalyzers</span>
                            <div class="fs-7 d-flex flex-lg-column flex-sm-row column-gap-5">
                                <table class="table table-sm mb-1 mb-lg-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Station:</td>
                                            <td class="text-end"><?= $value['target']['station'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Station type:</td>
                                            <td class="text-end"><?= $value['target']['type']?></td>
                                        </tr>
                                        <tr>
                                            <td>Landing pad:</td>
                                            <td class="text-end"><?= $value['target']['pad'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>System:</td>
                                            <td class="text-end"><?= $value['target']['system'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Distance from star:</td>
                                            <td class="text-end"><?= $value['target']['distance_ls'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-sm mb-1 table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Price:</td>
                                            <td class="text-end"><?= $value['target']['buy_price'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supply:</td>
                                            <td class="text-end"><?= $value['target']['stock'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Updated:</td>
                                            <td class="text-end"><?= $value['target']['time_diff'] ?></td>
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
