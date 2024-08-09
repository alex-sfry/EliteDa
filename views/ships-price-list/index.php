<?php

use app\models\ar\ShipsPriceList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\ShipsPriceListSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ships Price Lists';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="ships-price-list-index container-xxl px-5 mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ships Price List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'name',
            'price',
        [
        'class' => ActionColumn::class,
        'urlCreator' => function ($action, ShipsPriceList $model, $key, $index, $column) {
        return Url::toRoute([$action, 'name' => $model->name]);
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
