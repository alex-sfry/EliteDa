<?php

use app\models\ar\Allegiance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AllegianceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Allegiances';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between">
    <div class="allegiance-index container-xxl px-5 mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Allegiance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'id',
            'faction_id',
            'faction_name',
        [
        'class' => ActionColumn::class,
        'urlCreator' => function ($action, Allegiance $model, $key, $index, $column) {
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
