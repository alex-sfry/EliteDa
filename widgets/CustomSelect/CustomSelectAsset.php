<?php

namespace app\widgets\CustomSelect;

use yii\web\AssetBundle;
use yii\web\View;

class CustomSelectAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CustomSelect/assets';
    public $css = [YII_ENV_DEV ? 'CustomSelect.css' : 'CustomSelect.min.css'];
    public $js = [YII_ENV_DEV ? 'CustomSelect.js' : 'CustomSelect.min.js'];
    public $publishOptions = ['forceCopy' => YII_ENV_DEV ? true : false];

    public $depends = [
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapAsset',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
