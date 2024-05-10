<?php

namespace app\widgets\InputDropdown;

use yii\web\AssetBundle;
use yii\web\View;

class InputDropdownAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/InputDropdown/assets';
    public $css = [YII_ENV_DEV ? 'InputDropdown.css' : 'InputDropdown.min.css'];
    public $js = [YII_ENV_DEV ? 'InputDropdown.js' : 'InputDropdown.min.js'];
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
