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

$formatter = \Yii::$app->formatter;
$formatter->decimalSeparator = ' ';

$th = [
    'name' => ['sortable' => true, 'sort_dir' => ''],
    'population' => ['sortable' => true, 'sort_dir' => ''],
    'allegiance' => ['sortable' => true, 'sort_dir' => ''],
    'economy' => ['sortable' => true, 'sort_dir' => ''],
    'security' => ['sortable' => true, 'sort_dir' => ''],
];
$msg = 'first 100(max) systems sorted by name:';

if (isset($models[0]['distance'])) {
    $th['distance (ly)'] = ['sortable' => true, 'sort_dir' => 'ascending'];
    $msg = 'first 100(max) systems sorted by distance from ref. system:';
} else {
    $th['name']['sort_dir'] = 'ascending';
}

$th_cls = 'w-f-content text-nowrap bg-secondary-subtle';
$td_cls = 'w-f-content text-nowrap';
SortableAsset::register($this);
?>

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
                            Url::toRoute(["system/{$value['id']}"]),
                            ['class' => ['text-decoration-underline', 'link-underline-primary', 'table-link']]
                        ) ?>
                    </td>
                    <td class="<?= $td_cls ?>" data-sort="<?= e($value['population']) ?>">
                        <?= $formatter->asInteger(e($value['population'])) ?>
                    </td>
                    <td class="<?= $td_cls ?>"><?= e($value['faction_name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['economy_name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['security_level']) ?></td>
                    <?php if (isset($value['distance'])) { ?>
                        <td class='$td_cls'><?= e($value['distance']) ?></td>
                    <?php } ?>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>