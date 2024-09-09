<?php

/**
 * @var yii\web\View $this
 * @var yii\data\Pagination $pagination
 * @var yii\data\Sort $sort
 */

use function app\helpers\d;
use function app\helpers\e;

$th_cls = 'w-f-content text-nowrap align-content-center  bg-secondary-subtle';
$td_cls = 'w-f-content text-nowrap';

$th = [
    ['label' => 'Name',/*  'sort_link' => null, */ 'cls' => $th_cls],
    ['label' => 'System',/*  'sort_link' => null, */ 'cls' => $th_cls],
    ['label' => 'Dist. to arr (ls)',/*  'sort_link' => null, */ 'cls' => $th_cls],
    [
        'label' => 'Distance (LY)',
        // 'sort_link' => $sort->link(
        //     'distance',
        //     [
        //         'label' => '<span>Distance (LY)</span>',
        //         'class' => 'd-flex w-100 h-100 p-1 justify-content-between align-items-center gap-0 gap-sm-1'
        //     ]
        // ),
        // 'cls' => $th_cls . ' sortable'
        'cls' => $th_cls
    ]
];
?>

<div class="table-responsive px-1 link-danger">
    <table class="c-table table table-sm table-striped fs-7 rounded-2 overflow-hidden border">
        <thead>
            <tr class="border-1 border-dark sintony-bold fw-bold text-uppercase">
                <?php foreach ($th as $item) : ?>
                    <th
                        scope="col"
                        class="<?= $item['cls'] ?>">
                        <?php /* if ($item['sort_link']) { */ ?>
                            <?php /* echo $item['sort_link'] */ ?>
                        <?php /* } else { */ ?>
                            <?php echo $item['label'] ?>
                        <?php /* } */ ?>

                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $key => $value) : ?>
                <tr>
                    <td class="<?= $td_cls ?>"><?= e($value['name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['system_name']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['distance_to_arrival']) ?></td>
                    <td class="<?= $td_cls ?>"><?= e($value['distance']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
