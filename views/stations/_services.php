<?php

use yii\helpers\Url;

$st_services = [
    ['label' => 'market', 'url' => 'market'],
    ['label' => 'outfitting', 'url' => 'ship-modules-hardpoint'],
    ['label' => 'ships', 'url' => 'ships'],
];
?>

<div class="small-tile text-light gx-0 rounded-3">
    <a
        class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column justify-content-center sintony-bold"
        href="<?= Url::to(["station/$id"]) ?>">
        station info
    </a>
</div>
<?php foreach ($st_services as $key => $value) { ?>
    <div class="small-tile text-light gx-0 rounded-3">
        <a class="nav-button h-100 btn btn-violet border-0 text-light d-flex flex-column justify-content-center  sintony-bold <?= !$services[$value['label']] ? 'disabled' : null ?><?= $value['label'] === $active ? 'active' : null ?>"
            href="<?= $services[$value['label']] ?
                        Url::toRoute(["station/{$value['url']}/$id"]) : Url::to() ?>">
            <?= $value['label'] ?>
        </a>
    </div>
<?php  } ?>