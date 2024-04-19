<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Twitter Bootstrap 5 CSS bundle.
 */
class BootstrapAssetMin extends AssetBundle
{
    /**
     * @inheritDoc
     */
//    public $sourcePath = '@bower/bootstrap';
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /**
     * @inheritDoc
     */
    public $css = [
        'templates/css/bootstrap.min.css'
    ];
    public $js = [
        'templates/js/bootstrap.min.js'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
