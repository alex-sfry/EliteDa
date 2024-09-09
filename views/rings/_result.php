<?php

/**
 * @var yii\web\View $this
 * @var yii\data\Pagination $pagination
 * @var yii\data\Sort $sort
 */

use app\widgets\pagecounter\PageCounter;
use yii\bootstrap5\LinkPager;

use function app\helpers\d;
use function app\helpers\e;

$th = [
    ['label' => 'Name', /* 'sort_link' => null, */ 'cls' => 'w-f-content text-nowrap align-content-center'],
    ['label' => 'Type', /* 'sort_link' => null, */ 'cls' => 'w-f-content text-nowrap align-content-center'],
    ['label' => 'Reserve', /* 'sort_link' => null, */ 'cls' => 'w-f-content text-nowrap align-content-center'],
    ['label' => 'System', /* 'sort_link' => null, */ 'cls' => 'w-f-content text-nowrap align-content-center'],
    [
        'label' => 'Dist. to arr(ls)',
        /* 'sort_link' => $sort->link(
            'distance_to_arrival',
            [
                'label' => '<span>Dist. to arr(ls)</span>',
                'class' => 'd-flex w-100 h-100 p-1 justify-content-between align-items-center gap-0 gap-sm-1'
            ]
        ), */
        'cls' => 'w-f-content text-nowrap align-content-center sortable'
    ],
    [
        'label' => 'Distance (LY)',
        /* 'sort_link' => $sort->link(
            'distance',
            [
                'label' => '<span>Distance (LY)</span>',
                'class' => 'd-flex w-100 h-100 p-1 justify-content-between align-items-center gap-0 gap-sm-1'
            ]
        ), */
        'cls' => 'w-f-content text-nowrap align-content-center sortable'
    ]
];

$td_cls = 'w-f-content text-nowrap';
?>

<div class="table-responsive px-1 link-danger">
    <table class="c-table table table-sm table-striped fs-7 rounded-2 overflow-hidden border">
        <thead>
            <tr class="border-1 border-dark sintony-bold fw-bold text-uppercase">
                <?php foreach ($th as $item) : ?>
                    <th
                        scope="col"
                        class="<?= $item['cls'] ?>">
                        <?= $item['label'] ?>
                        <?php /* if ($item['sort_link']) { */ ?>
                            <?php /* echo $item['sort_link'] */ ?>
                        <?php /* } else { */ ?>
                            <?php /* echo $item['label'] */ ?>
                        <?php /* } */ ?>

                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $key => $value) : ?>
                <tr>
                    <td class="<?= $td_cls ?>"><?= e($value['name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['type']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['reserve']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['system_name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['distance_to_arrival']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['distance']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="c-pagination-cnt d-flex flex-column align-items-center align-items-center pb-2 gap-1">
    <div class="">
        <?php /* echo LinkPager::widget([
            'pagination' => $pagination,
            'maxButtonCount' => 5,
            'firstPageLabel' => 'first',
            'lastPageLabel' => 'last',
            'prevPageCssClass' => 'prev-page',
            'nextPageCssClass' => 'next-page'
        ]) */ ?>
    </div>
    <?php echo PageCounter::widget(['pagination' => $pagination, 'cls' => 'text-light']) ?>
</div>
