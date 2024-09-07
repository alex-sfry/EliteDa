<?php

/**
 * @var yii\web\View $this
 * @var yii\data\Pagination $pagination
 * @var yii\data\Sort $sort
 */

use yii\bootstrap5\LinkPager;

use function app\helpers\d;
use function app\helpers\e;

$th = [
    ['label' => 'Name', 'sort_link' => null],
    ['label' => 'Type', 'sort_link' => null],
    ['label' => 'Reserve', 'sort_link' => null],
    ['label' => 'System', 'sort_link' => null],
    [
        'label' => 'Dist. to arr(ls)',
        'sort_link' => $sort->link(
            'distance_to_arrival',
            ['label' => 'Dist. to arr(ls)', 'class' => 'd-block w-100 h-100 p-1']
        )
    ],
    [
        'label' => 'Distance (LY)',
        'sort_link' => $sort->link(
            'distance',
            ['label' => 'Distance (LY)', 'class' => 'd-flex w-100 h-100 p-1']
        )
    ]
];
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

<div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <?php foreach ($th as $item) : ?>
                    <th scope="col" class="<?= $item['sort_link'] ? 'p-0' : null ?>">
                        <?php if ($item['sort_link']) : ?>
                            <?= $item['sort_link'] ?>
                        <?php else : ?>
                            <?= $item['label'] ?>
                        <?php endif; ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $key => $value) : ?>
                <tr>
                    <td><?= e($value['name']) ?></td>
                    <td><?= e($value['type']) ?></td>
                    <td><?= e($value['reserve']) ?></td>
                    <td><?= e($value['system_name']) ?></td>
                    <td><?= e($value['distance_to_arrival']) ?></td>
                    <td><?= e($value['distance']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="c-pagination-cnt d-flex justify-content-center align-items-center pb-4">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'maxButtonCount' => 5,
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'prevPageCssClass' => 'prev-page',
        'nextPageCssClass' => 'next-page'
    ]) ?>
</div>

<!-- <div class="bg-light"><?php /* d($models, false); */ ?></div> -->
<!-- <div class="bg-light"><?php /* echo $pagination->totalCount */ ?></div>
<div class="bg-light">
    <a class="btn btn-primary btn-sm" href="<?php /* echo $sort->createUrl('distance') */ ?>">
        Sort by Distance (LY)
    </a>
    <a class="btn btn-primary btn-sm" href="<?php /* echo $sort->createUrl('distance_to_arrival') */ ?>">
        Sort by Distance (ls)
    </a>
</div> -->