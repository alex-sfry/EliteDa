<?php

/**
 * @var yii\web\View $this
 * @var array $models
 */

use app\assets\SortableAsset;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\d;
use function app\helpers\e;

$th = [
    'name' => ['sortable' => true, 'sort_dir' => ''],
    'pad' => ['sortable' => true, 'sort_dir' => ''],
    'type' => ['sortable' => true, 'sort_dir' => ''],
    'dist. to arr. (ls)' => ['sortable' => true, 'sort_dir' => ''],
    'economy' => ['sortable' => true, 'sort_dir' => ''],
    'government' => ['sortable' => true, 'sort_dir' => ''],
    'allegiance' => ['sortable' => true, 'sort_dir' => ''],
    'system' => ['sortable' => true, 'sort_dir' => ''],
];
$msg = 'first 100(max) stations sorted by name:';

if (isset($models[0]['distance'])) {
    $th['distance (ly)'] = ['sortable' => true, 'sort_dir' => 'ascending'];
    $msg = 'first 100(max) stations sorted by distance from ref. system:';
} else {
    $th['name']['sort_dir'] = 'ascending';
}

$th_cls = 'w-f-content text-nowrap bg-secondary-subtle';
$td_cls = 'w-f-content text-nowrap';
$td_surface_cls = ['text-primary', 'text-success'];
$tooltip = 'Not all Odyssey Settlements have L pad';
SortableAsset::register($this);
// d($models);
?>

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
                    <td class="<?= $td_cls ?>">
                        <?= Html::a(
                            e($value['name']),
                            Url::toRoute(["station/{$value['id']}"]),
                            ['class' => ['text-decoration-underline', 'link-underline-primary', 'table-link']]
                        ) ?>
                    </td>
                    <td class="<?= $td_cls ?>">
                        <span
                            class="<?= $value['type'] === 'Odyssey Settlement' ? 't-tip' : null ?>"
                            data-bs-toggle="<?= $value['type'] === 'Odyssey Settlement' ? 'tooltip' : null ?>"
                            data-bs-title="<?= $value['type'] === 'Odyssey Settlement' ? $tooltip  : null ?>">
                            <?= e($value['pad']) ?>
                        </span>
                    </td>
                    <td class="<?= $td_cls ?> fw-bold <?= $td_surface_cls[$value['surface']] ?>">
                        <?= e($value['type']) ?>
                    </td>
                    <td class="<?= $td_cls ?>"><?= e($value['distance_to_arrival']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['economyId1']['economy_name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['government']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['allegiance']['faction_name']) ?></td>
                    <td class="<?= $td_cls ?>">
                        <?php if (isset($value['system'])) { ?>
                            <?= Html::a(
                                e($value['system']['name']),
                                Url::toRoute(["system/{$value['system']['id']}"]),
                                ['class' => ['text-decoration-underline', 'link-underline-primary', 'table-link']]
                            ); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>
                    <?php if (isset($value['distance'])) { ?>
                        <td class='$td_cls'><?= e($value['distance']) ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>