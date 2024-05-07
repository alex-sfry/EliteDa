<?php

namespace app\widgets\Table;

use yii\web\AssetBundle;
use yii\web\View;

class TableAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/Table/assets';
    public $css = [/* 'InputDropdown.css' */];
    public $js = [/* 'InputDropdown.js' */];

    public $depends = [
//        'yii\web\YiiAsset',
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
