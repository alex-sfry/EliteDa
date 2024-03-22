<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
//use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
    <div class="body-wrapper d-flex flex-column justify-content-between overflow-x-hidden">
        <header id="header" class="header bg-header">
            <nav class="navbar navbar-expand-lg bg-header py-0 position-relative z-3">
                <div class="container-xxl my-0 mx-auto px-3">
                    <a class="logo navbar-brand d-block text-center" href="<?= Url::home() ?>">elida</a>
                    <button
                        class="navbar-toggler bg-light-orange"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="menu navbar-nav d-flex w-100 flex-md-wrap justify-content-center
                            align-content-center gap-lg-5">
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    aria-current="page"
                                    href="<?= Url::to(['commodities/index']) ?>"
                                >
                                    commodities
                                </a>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0">
                                <a class="menu__link nav-link text-uppercase text-light"
                                   href="<?= Url::to(['trade-routes/index']) ?>">
                                    trade routes
                                </a>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0">
                                <a class="menu__link nav-link text-uppercase text-light" href="#">
                                    Engineering
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <?= Alert::widget() ?>
        <?= $content ?>

        <footer id="footer" class="footer bg-header py-2">
            <div class="container-xxl px-3">
                <p class="my-0 text-light-orange mx-auto">
                    This website is not an official tool for the game Elite: Dangerous and is not affiliated
                    with Frontier Developments.
                    All information provided is based on publicly available information and data supplied by players,
                    and may not be entirely accurate. 'Elite', the Elite logo, the Elite: Dangerous logo, 'Frontier'
                    and the Frontier logo are registered trademarks of Frontier Developments plc.
                    All rights reserved. All other trademarks and copyrights are acknowledged as the property of their
                    respective owners.
                </p>
            </div>
        </footer>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
