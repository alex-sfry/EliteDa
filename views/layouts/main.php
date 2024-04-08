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
<body class="d-flex flex-column" style="height:100vh">
<?php $this->beginBody() ?>
    <div class="body-wrapper bg-main-background d-flex flex-column justify-content-between overflow-x-hidden
        overflow-y-scroll">
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
                        <div class="d-flex nowrap justify-content-center align-items-center justify-content-lg-start
                                        align-items-lg-start order-last">
                                <?php if (Yii::$app->user->isGuest) : ?>
                                    <a class="sintony-reg text-light" href="<?= Url::to(['user/signup']) ?>">
                                        Register
                                    </a>
                                    <span class="text-light mx-1">|</span>
                                    <a class="sintony-reg text-light" href="<?= Url::to(['user/login']) ?>">Login</a>
                                <?php else : ?>
                                    <div class="row justify-content-start flex-row flex-lg-column row-gap-1 g-0">
                                        <div class="col">
                                            <span
                                                class="sintony-reg nowrap text-info text-decoration-underline"
                                                style=" white-space: nowrap;">
                                                Welcome, <?= Yii::$app->user->identity->username ?>
                                            </span>
                                        </div>
                                        <div class="col col-lg-8">
                                            <a
                                                href="/user/logout"
                                                class="sintony-reg nowrap text-warning ms-2 ms-lg-0 rounded-1
                                            text-light bg-light-orange p-1">
                                                Log out
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                        </div>
                        <ul class="menu navbar-nav d-flex w-100 flex-md-wrap justify-content-center
                            align-content-center gap-lg-5">
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    aria-current="page"
                                    href="<?= Url::to(['commodities/index']) ?>"
                                >
                                    commodities
                                </a>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative">
                                <a class="menu__link nav-link text-uppercase text-light"
                                   href="<?= Url::to(['trade-routes/index']) ?>">
                                    trade routes
                                </a>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative dropdown">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Engineering
                                </a>
                                <ul class="dropdown-menu border-light-orange rounded-2 bg-header mt-0 py-0">
                                    <li class="dropdown-item py-0 rounded-2">
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['material-traders/index']) ?>">
                                            Material traders
                                        </a>
                                    </li>
                                </ul>
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
