<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'templates/css/main.min.css',
//        'templates/css/bootstrap.min.css'
    ];
    public $js = [
//        'templates/js/bootstrap.min.js',
        'templates/js/main.min.js'
    ];
    public $depends = [
//        'yii\web\YiiAsset',
        'app\assets\BootstrapAssetMin',
//        'app\assets\YiiAssetMin',
//        'yii\bootstrap5\BootstrapAsset'
    ];
}
