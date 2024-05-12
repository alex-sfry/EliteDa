<?php

/**
 * @var string $container
 * @var array $model
 * @var array $columns
 * @var array $column_filters
 * @var array $column_labels
*/

use yii\helpers\Html;
use yii\helpers\VarDumper;

// Yii::$app->view->registerJs('');

// $classes = [];
?>

<style>
    .w-table thead th,
    .w-table thead td {
        width: fit-content;
    }
</style>

<div id="<?= $container ?>" class="rounded-2 table-responsive">
    <table class="w-table fs-7 table table-striped mb-0 <?= count($model) > 0 ? 'overflow-x-auto' :
                'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($column_labels as $label) : ?>
                <th class='bg-light-orange p-2 text-body text-nowrap' scope='col'><?= $label ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($column_filters as $filter) : ?>
                <td><?= $filter ?></td>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($model as $item) : ?>
                <tr>
                    <?php foreach ($item as $key => $value) : ?>
                        <td class="text-start text-truncate"><?= Html::encode($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>