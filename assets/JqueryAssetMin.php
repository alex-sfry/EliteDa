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
 * This asset bundle provides the [jQuery](https://jquery.com/) JavaScript library.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JqueryAssetMin extends AssetBundle
{
    public $sourcePath = '@bower/jquery/dist';
    public $js = [
        'jquery.min.js',
    ];
    public $jsOptions = [
//        'defer' => '',
        'position' => View::POS_HEAD
    ];
}
