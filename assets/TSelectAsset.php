<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class TSelectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['node_modules/tom-select/dist/css/tom-select.bootstrap5.min.css'];
<<<<<<< HEAD
    public $js = ['node_modules/tom-select/dist/js/tom-select.popular.min.js'];
=======
    public $js = ['templates/js/tom-select.popular.min.js'];
>>>>>>> 32973e773f0d2bf59601247561f96a66da71bac4
    public $jsOptions = ['position' => View::POS_END];
    public $depends = [];
}
