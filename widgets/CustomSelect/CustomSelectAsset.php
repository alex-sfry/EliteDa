<?php

namespace app\widgets\CustomSelect;

use yii\web\AssetBundle;
use yii\web\View;

class CustomSelectAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CustomSelect/assets';
    public $css = ['CustomSelect.css'];
    public $js = ['CustomSelect.js'];

    public $depends = [
        'app\assets\BootstrapAssetMin',
        'app\assets\AppAsset'
    ];
    public $jsOptions = [
        // 'defer' => '',
        'position' => View::POS_END
    ];
}
