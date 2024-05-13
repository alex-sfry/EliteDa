<?php

/**
 * @var string $container
 * @var array $model
 * @var array $columns
 * @var array $column_filters
 * @var array $column_labels
 * @var array $filtered_columns
*/

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\VarDumper;

Yii::$app->view->registerJs(
    "
    let container ='$container';
    ",
    View::POS_BEGIN
);

Yii::$app->view->registerCss($styles, [View::POS_BEGIN]);
?>

<div id="<?= $container ?>" class="rounded-2 table-responsive">
    <table class="sortable <?= $default_sorting ?> w-table fs-7 table table-striped mb-0 
                <?= count($model) > 0 ? 'overflow-x-auto' : 'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($column_labels as $label) : ?>
                <th class='bg-light-orange p-2 text-body text-nowrap indicator-right' scope='col'>
                    <span><?= $label ?></span>
                </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($column_filters as $key => $value) : ?>
                <td>
                    <?= match ($value['type']) {
                        'dropDownList' => Html::dropDownList(
                            $value['name'],
                            null,
                            $value['option_items'],
                            [
                                'class' => [
                                    'form-select',
                                    'text-center',
                                    'py-1',
                                    'fs-7'
                                ],
                                'style' => 'box-shadow: none;border-color: var(--bs-gray-300);'
                            ]
                        ),
                        'textInput' => Html::textInput(
                            $value['name'],
                            null, [
                                'class' => [
                                    'form-control',
                                    'py-1',
                                    'fs-7'
                                ],
                                'style' => 'box-shadow: none;border-color: var(--bs-gray-300);'
                            ]
                        ),
                        default => ''
                    } ?>
                </td>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($model as $i => $item) : ?>
                <tr>
                    <?php foreach ($item as $key => $value) : ?>
                        <?php $index = array_search($key, array_keys($item)); ?>
                        <td 
                            class="
                                <?= isset($columns[$index]['class']) ? $columns[$index]['class'] : null ?> text-truncate
                            " 
                            data-sort="<?= Html::encode($value) ?>">
                            <?= Html::encode($value) ?>
                            <?= $key === 'sell_price' || $key === 'buy_price' ? ' Cr' : null; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
