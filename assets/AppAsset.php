<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

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
        YII_ENV_DEV ? 'templates/css/main.css'  : 'templates/css/main.min.css',
    ];
    public $js = [
        YII_ENV_DEV ? 'templates/js/main.js' : 'templates/js/main.min.js'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap5\BootstrapPluginAsset',
       'yii\bootstrap5\BootstrapAsset',
    ];
}
