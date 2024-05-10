<?php

namespace app\widgets\Table;

use yii\web\AssetBundle;
use yii\web\View;

class TableAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/Table/assets';
    public $css = [/* YII_ENV_DEV ? 'Table.css' : 'Table.min.css' */];
    public $js = [/* 'InputDropdown.js' */];
    // public $publishOptions = ['forceCopy' => true];

    public $depends = [
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
