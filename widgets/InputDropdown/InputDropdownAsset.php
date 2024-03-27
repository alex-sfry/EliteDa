<?php

namespace app\widgets\InputDropdown;

use yii\web\AssetBundle;
use yii\web\View;

class InputDropdownAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/InputDropdown/assets';
    public $css = ['InputDropdown.css'];
    public $js = ['InputDropdown.js'];

    public $depends = [
//        'yii\web\YiiAsset',
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        'defer' => '',
        'position' => View::POS_HEAD
    ];
}
