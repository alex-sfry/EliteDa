<?php

/**
 * @var string $container
 * @var array $model
 * @var array $columns
 * @var array $column_filters
 * @var array $column_labels
 * @var array $filtered_columns
*/

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

Yii::$app->view->registerJs(
    "
    let container ='$container';
    new TableJs(container);
    ",
    View::POS_END
);

Yii::$app->view->registerCss($styles, [View::POS_BEGIN]);
?>

<div id="<?= $container ?>" class="rounded-2 table-responsive">
    <table class="sortable <?= $default_sorting ?> w-table fs-7 table table-striped mb-0 
                <?= count($model) > 0 ? 'overflow-x-auto' : 'overflow-hidden' ?>">
        <thead>
            <tr>
                <?php foreach ($columns as $key => $value) : ?>
                <th 
                    class='bg-light-orange p-2 text-body text-nowrap indicator-right
                        <?= isset($value['sort']) && !$value['sort'] ? 'no-sort' : null ?>'
                    scope='col'>
                    <span>
                        <?= isset($value['label']) ?
                            Html::encode($value['label']) : Html::encode($value['attribute']) ?>
                    </span>
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
            <?php foreach ($model as $item) : ?>
                <tr>
                    <?php foreach ($columns as $value) : ?>
                        <td 
                            class="<?= isset($value['class']) ? $value['class'] : null ?> text-truncate">
                            <?php
                            $link_label = $value['textBefore'] ?? null;
                            $link_label .= isset($item[$value['attribute']]) ?
                                        Html::encode($item[$value['attribute']]) : '--';
                            $link_label .= $value['textAfter'] ?? null;
                            ?>
                            <?= isset($item['req_url']) ? Html::a(
                                $link_label,
                                Url::to(ArrayHelper::merge(['commodities/index'], $item['req_url']))
                            ) : $link_label ?>
                            
                            
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
