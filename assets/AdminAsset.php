<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AdminAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@app/admin/assets';
    public $css = [];
    public $js = ['script.js'];
    public $jsOptions = ['position' => View::POS_END];
    public $depends = ['yii\web\JqueryAsset'];
    public $publishOptions = ["forceCopy" => YII_DEBUG];
}
