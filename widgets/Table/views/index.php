<?php

/**
 * @var string $container
 * @var array $model
 * @var array $columns
 * @var array $column_filters
 * @var array $column_labels
*/

use yii\helpers\Html;

Yii::$app->view->registerJs('');

$classes = [];
?>

<div id="<?= $container ?>" class="position-relative">
    <table class="c-table fs-7 table table-striped mb-0 <?= count($model) > 0 ? 'overflow-x-auto' :
                'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($column_labels as $label) : ?>
                <th><?= $label ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($column_filters as $filter) : ?>
                <td><?= $filter ?></td>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>

            </tr>
        </tbody>
    </table>
</div>