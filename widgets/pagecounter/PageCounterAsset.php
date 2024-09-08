<?php

namespace app\widgets\pagecounter;

use yii\web\AssetBundle;

class PageCounterAsset extends AssetBundle
{
    // public $sourcePath = '@app/widgets/alext/pagecounter/assets';
    // public $css = [YII_ENV_DEV ? '' : ''];
    // public $js = [YII_ENV_DEV ? '' : ''];
    // public $publishOptions = ['forceCopy' => YII_ENV_DEV ? true : false];
    public $depends = ['yii\bootstrap5\BootstrapAsset'];
    public $jsOptions = [];
}
