<?php

use app\models\ar\ShipsList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\ShipsListSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ships Lists';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin-dashboard/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-list-index container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(
                'Create Ships List',
                Url::to(['admin-dashboard/ships-list/create']),
                ['class' => 'btn btn-success']
            ) ?>
        </p>

        <?php
        // echo $this->render('_search', ['model' => $searchModel]);
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'symbol',
                'name',
                'entitlement:ntext',
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, ShipsList $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'symbol' => $model->symbol]);
                    }
                ],
            ],
            'pager' => [
                'class' => 'yii\bootstrap5\LinkPager',
                'firstPageLabel' => 'first',
                'lastPageLabel' => 'last',
                'prevPageCssClass' => 'prev-page',
                'nextPageCssClass' => 'next-page',
                'options' => [
                    'class' => 'd-flex justify-content-center'
                ]
            ],
        ]); ?>

    </div>
</main>