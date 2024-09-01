<?php

namespace app\widgets\InputDropdown;

use yii\web\AssetBundle;
use yii\web\View;

class InputDropdownAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/InputDropdown/assets';
    public $css = [YII_ENV_DEV ? 'InputDropdown.css' : 'InputDropdown.min.css'];
    public $js = [YII_ENV_DEV ? 'InputDropdown.js' : 'InputDropdown.min.js'];
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
