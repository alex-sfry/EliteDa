<?php

use yii\helpers\VarDumper;

function d(mixed $var, bool $die = true): void
{
    VarDumper::dump($var, 10, true);
    $die && die();
}
