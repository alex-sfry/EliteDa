<?php

namespace app\helpers;

function d(mixed $var, bool $die = true): void
{
    echo '<div class="bg-light>';
    Dumper::dump($var);
    $die && die();
    echo '</div>';
}
