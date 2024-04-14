<?php

/**
 * @var array $engineers
 * @var array $find_file
 */

use yii\helpers\VarDumper;

?>

<div class="bg-light">
    <p><?= $engineers[0]['name'] ?></p>
    <?php
    VarDumper::dump($engineers, 10, true);
    ?>
</div>
