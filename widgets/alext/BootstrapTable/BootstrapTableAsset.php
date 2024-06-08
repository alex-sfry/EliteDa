<?php

namespace app\widgets\alext\BootstrapTable;

use yii\web\AssetBundle;
use yii\web\View;

class BootstrapTableAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/alext/BootstrapTable/assets';
    public $css = [YII_ENV_DEV ? 'BootstrapTable.css' : 'BootstrapTable.min.css'];
    public $js = [YII_ENV_DEV ? 'BootstrapTable.js' : 'BootstrapTable.min.js'];
    public $publishOptions = ['forceCopy' => YII_ENV_DEV ? true : false];

    public $depends = [
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END,
        'type' => 'module'
    ];
}
