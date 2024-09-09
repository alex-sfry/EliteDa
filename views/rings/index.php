<?php

/**
 * @var yii\web\View $this
 * @var yii\data\Pagination $pagination
 * @var yii\data\Sort $sort
 */

use app\assets\TSelectAsset;

$this->title = "Search for \r\n Pristine Metallic rings";
TSelectAsset::register($this);
$this->params['breadcrumbs'] = [$this->title];
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row flex-column justify-content-center align-items-center row-gap-4">
            <div class="col-sm-9 col-md-7 col-lg-6 col-xl-4">
                <div class='d-flex flex-column w-100 gap-3'>
                    <h1 class='mt-2 text-center fs-2 sintony-bold'><?= nl2br($this->title) ?></h1>

                    <!-- accordion-form -->
                    <?= $this->render('_accordion', ['form_model' => $form_model]) ?>
                    <!-- end of accordion-form -->

                </div>
            </div>

            <!-- result -->
            <div class="col d-flex flex-column">
                <?php if (isset($models) && !empty($models)) : ?>
                    <?= $this->render('_result', [
                        'pagination' => $pagination,
                        // 'sort' => $sort,
                        'models' => $models
                    ]) ?>
                <?php endif; ?>
            </div>
            <!-- end ofresult -->

        </div>
    </div>
</main>