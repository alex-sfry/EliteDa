<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
// use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
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
    <div class="cookies-consent-wrapper hide">
        <img src="#" alt="">
        <div class="content">
            <header>Cookies Consent</header>
            <p>This website use cookies to ensure you get the best experience on our website.</p>
            <div class="buttons">
                <button class="item">I understand</button>
                <!-- <a href="#" class="item">Learn more</a> -->
            </div>
        </div>
    </div>
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
                                    <a class="sintony-reg text-light" href="<?= Url::to(['user/login']) ?>">Login</a>
                                <?php else : ?>
                                    <div class="row justify-content-start flex-row flex-lg-column row-gap-1 g-0">
                                        <div class="col">
                                            <span
                                                class="sintony-reg nowrap text-info text-decoration-underline"
                                                style=" white-space: nowrap;">
                                                <?= Yii::$app->user->identity->username ?>
                                            </span>
                                        </div>
                                        <div class="col col-lg-8">
                                            <a
                                                href="/user/logout"
                                                class="sintony-reg text-warning ms-2 ms-lg-0 rounded-1
                                            text-light bg-info p-1"
                                                style=" white-space: nowrap;">
                                                Log out
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                        </div>
                        <ul class="menu navbar-nav d-flex w-100 flex-md-wrap justify-content-center
                            align-content-center gap-lg-5">
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative dropdown">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    market
                                </a>
                                <ul class="dropdown-menu border-light-orange rounded-2 bg-header mt-0 py-0">
                                    <li class="dropdown-item py-0 rounded-2">
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light 
                                            dropdown-item"
                                            aria-current="page"
                                            href="<?= Url::to(['commodities/index']) ?>">
                                            commodities
                                        </a>
                                        <a 
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light 
                                            dropdown-item"
                                            href="<?= Url::to(['trade-routes/index']) ?>">
                                            trade routes
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative dropdown">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    engineering
                                </a>
                                <ul class="dropdown-menu border-light-orange rounded-2 bg-header mt-0 py-0">
                                    <li class="dropdown-item py-0 rounded-2">
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['engineers/index']) ?>">
                                            engineers
                                        </a>
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['material-traders/index']) ?>">
                                            material traders
                                        </a>
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['materials/index']) ?>">
                                            materials
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item nav-item text-center mb-2 mb-lg-0 position-relative dropdown">
                                <a
                                    class="menu__link nav-link text-uppercase text-light"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    shipyard
                                </a>
                                <ul class="dropdown-menu border-light-orange rounded-2 bg-header mt-0 py-0">
                                    <li class="dropdown-item py-0 rounded-2">
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['shipyard-ships/index']) ?>">
                                            ships
                                        </a>
                                        <a
                                            class="menu__link menu__link_nested nav-link text-uppercase text-light
                                                    dropdown-item"
                                            href="<?= Url::to(['ship-modules/index']) ?>">
                                            ship modules
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li style='--bs-breadcrumb-divider-color: white;' 
                            class='breadcrumb-item text-light'><i>{link}</i></li>\n",
            'activeItemTemplate' => "<li style='--bs-breadcrumb-divider-color: white;'
                                        class='breadcrumb-item text-info'><i><b>{link}</b></i></li>\n",
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'navOptions' => [
                'aria-label' => "breadcrumb",
                'class' => 'px-4'
            ]
        ]); ?>
        <?= Alert::widget() ?>

        <?= $content ?>

        <footer id="footer" class="footer bg-header py-2">
            <div class="container-xxl px-3 h-100">
                <div class="row column-gap-1 row-gap-2 column-gap-sm-0 flex-column flex-sm-row 
                            justify-content-sm-between">
                    <div class="col-sm-10 col-12">
                        <p class="my-0 text-warning">
                            This website is not an official tool for the game Elite: Dangerous and is not affiliated
                            with Frontier Developments.
                            All information provided is based on publicly available information and data supplied by 
                            players, and may not be entirely accurate. 'Elite', the Elite logo, 
                            the Elite: Dangerous logo, 'Frontier' and the Frontier logo are registered trademarks 
                            of Frontier Developments plc.
                            All rights reserved. All other trademarks and copyrights are acknowledged as the property 
                            of their respective owners.
                        </p>
                    </div>
                    <div class="contact-block col-sm-2 col-12 h-100 d-flex flex-column flex-sm-row gap-2 gap-md-0 
                                align-items-sm-center">
                        <div class="d-sm-block d-none bg-light px-0 h-100" style="min-width: 2px;"></div>
                        <div class="d-inline-flex d-sm-none bg-light px-0" style="height: 2px;"></div>
                        <a 
                            class="footer__link nav-link text-light text-uppercase sintony-bold fs-7 mx-auto"
                            href="<?= Url::to(['site/contact']) ?>">
                            contact
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
<?php
$this->endBody();
?>

</body>
</html>
<?php $this->endPage() ?>
