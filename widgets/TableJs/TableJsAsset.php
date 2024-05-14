<?php

namespace app\widgets\TableJs;

use yii\web\AssetBundle;
use yii\web\View;

class TableJsAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/TableJs/assets';
    public $css = [YII_ENV_DEV ? 'TableJs.css' : 'TableJs.min.css'];
    public $js = [
        'sortable.min.js',
        YII_ENV_DEV ? 'TableJs.js' : 'TableJs.min.js'
    ];
    public $publishOptions = ['forceCopy' => true];

    public $depends = [
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
