<?php

namespace app\helpers;

use yii\helpers\Html;

function ksq(string $str): string
{
    $str = str_replace("&#039;", 'n19t11a', $str);
    return str_replace('n19t11a', "&#039;", Html::encode($str));
}
