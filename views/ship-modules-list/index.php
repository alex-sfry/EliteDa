<?php

use app\models\ar\ShipModulesList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\ShipModulesListSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ship Modules Lists';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ship-modules-list-index container-xxl px-5 mt-3">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Ship Modules List', ['create'], ['class' => 'btn btn-success']) ?>
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
                'mount',
                'category',
                //'guidance',
                'ship',
                'class',
                'rating',
                //'entitlement:ntext',
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, ShipModulesList $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
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