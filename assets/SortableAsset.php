<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class SortableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = ['templates/js/sortable.min.js'];
    public $jsOptions = ['position' => View::POS_END];
    public $depends = [];
}
