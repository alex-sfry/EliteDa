<?php

/**
 * @var yii\web\View $this
 * @var array $models
 * @var array $commodity_names
 * @var string $stock_demand
 * @var string $price
 * @var string $sort_by
 */

use app\assets\SortableAsset;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\d;
use function app\helpers\e;

$formatter = \Yii::$app->formatter;

$th = [
    'commodity' => ['sortable' => true, 'sort_dir' => ''],
    'price' => ['sortable' => true, 'sort_dir' => ''],
    $stock_demand => ['sortable' => true, 'sort_dir' => ''],
    'station' => ['sortable' => true, 'sort_dir' => ''],
    'pad' => ['sortable' => true, 'sort_dir' => ''],
    'type' => ['sortable' => true, 'sort_dir' => ''],
    'dta(ls)' => ['sortable' => true, 'sort_dir' => ''],
    'system' => ['sortable' => true, 'sort_dir' => ''],
    'distance(LY)' => ['sortable' => true, 'sort_dir' => ''],
    'updated' => ['sortable' => true, 'sort_dir' => ''],
];

switch ($sort_by) {
    case 'Price':
        if ($price === 'sell_price') {
            $th['price']['sort_dir'] = 'descending';
        } elseif ($price === 'buy_price') {
            $th['price']['sort_dir'] = 'ascending';
        }
        break;
    case 'UpdatedAt':
        $th['updated']['sort_dir'] = 'ascending';
        break;
    default:
        $th['distance (LY)']['sort_dir'] = 'ascending';
        break;
}

$msg = 'first 100(max) stations:';

$th_cls = 'w-f-content text-nowrap bg-secondary-subtle';
$td_cls = 'w-f-content text-end text-center';
$td_surface_cls = ['text-primary', 'text-success'];
$tooltip = 'Not all Odyssey Settlements have L pad';
SortableAsset::register($this);
// d($models);
?>

<div class="d-flex gap-2 flex-wrap">
    <div class="c-result-legend bg-light text-center mt-3 rounded-2 py-1">
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
</div>
<div class="table-responsive px-1">
    <p class="result-info text-light text-center">
        <?= $msg ?>
    </p>
    <table class="c-table sortable asc table table-sm table-striped fs-7 rounded-2 overflow-hidden border">
        <thead>
            <tr class="border-1 border-dark sintony-bold fw-bold text-uppercase">
                <?php foreach ($th as $key => $value) { ?>
                    <th
                        scope="col"
                        class="<?= $th_cls ?>"
                        aria-sort="<?= $value['sortable'] ? $value['sort_dir'] : null ?>">
                        <span><?= $key ?></span>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $key => $value) { ?>
                <tr>
                    <td class="<?= $td_cls ?>"><?= $commodity_names[strtolower(e($value['name']))] ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value[$price]) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value[$stock_demand]) ?></td>
                    <td class="<?= $td_cls ?>">
                        <?= Html::a(
                            e($value['station']['name']),
                            Url::toRoute(["station/{$value['station']['id']}"]),
                            ['class' => ['text-decoration-underline', 'link-underline-primary', 'table-link']]
                        ) ?>
                    </td>
                    <td class="<?= $td_cls ?>">
                        <span
                            class="<?= $value['station']['type'] === 'Odyssey Settlement' ? 't-tip' : null ?>"
                            data-bs-toggle="<?= $value['station']['type'] === 'Odyssey Settlement' ?
                                                'tooltip' : null ?>"
                            data-bs-title="<?= $value['station']['type'] === 'Odyssey Settlement' ?
                                                $tooltip  : null ?>">
                            <?= e($value['pad']) ?>
                        </span>
                    </td>
                    <td class="<?= $td_cls ?> fw-bold <?= $td_surface_cls[$value['surface']] ?>">
                        <?= e($value['station']['type']) ?>
                    </td>
                    <td class="<?= $td_cls ?>"><?= e($value['station']['distance_to_arrival']) ?></td>
                    <td class="<?= $td_cls ?>">
                        <?php if (isset($value['station']['system'])) { ?>
                            <?= Html::a(
                                e($value['station']['system']['name']),
                                Url::toRoute(["system/{$value['station']['system']['id']}"]),
                                ['class' => ['text-decoration-underline', 'link-underline-primary', 'table-link']]
                            ); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>
                    <td class='<?= $td_cls ?>'><?= e($value['distance']) ?></td>
                    <td class="<?= $td_cls ?>" data-sort="<?= e($value['timestamp']) ?>">
                        <?= $formatter->asRelativeTime(e($value['timestamp'])) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
