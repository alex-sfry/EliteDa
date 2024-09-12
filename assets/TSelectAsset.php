<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class TSelectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['node_modules/tom-select/dist/css/tom-select.bootstrap5.min.css'];
    public $js = ['node_modules/tom-select/dist/js/tom-select.popular.min.js'];
    public $jsOptions = [
        'position' => View::POS_END,
        'type' => 'module'
    ];
    public $depends = [];
}
