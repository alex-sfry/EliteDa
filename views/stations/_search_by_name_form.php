<?php

/** @var View $this */
/** @var array $errors */
/** @var array $by_name_form_values */
/** @var StationsNameForm $by_name_form_values */

use yii\helpers\Html;

use function app\helpers\d;
use function app\helpers\e;

$search_name_cls = !empty($errors) ? 'is-invalid' : null;
?>

<div>
    <?= Html::beginForm(
        '/stations/',
        'get',
        [
            'id' => 'st-name-form',
            'novalidate' => true,
            'class' => [
                'fs-7',
                'bg-light',
                'rounded-2',
                'w-100',
                'px-1',
                'py-1'
            ],
        ]
    ) ?>
    <?= Html::label(
        'Search by name:',
        'stName',
        ['class' => ['text-nowrap', 'fs-6', 'fw-bold', 'align-content-center']]
    ) ?>
    <div class="d-flex align-items-baseline gap-3">
        <div class="w-75">
            <?= Html::input('search', 'stName', e($by_name_form_values['stName']), [
                'id' => 'stName',
                'name' => 'stName',
                'required' => true,
                'minlength' => 2,
                'class' => [
                    'form-control',
                    'form-control-sm',
                    'rounded-1',
                    'border-1',
                    $search_name_cls
                ]
            ]) ?>
            <div class="invalid-feedback fw-bold">
                <?= $errors['stName'][0] ?? 'Field must not be empty.' ?>
            </div>
        </div>
        <?= Html::button('search', [
            'type' => 'submit',
            'name' => 'stNameBtn',
            'class' => [
                'get-form',
                'btn',
                'btn-primary',
                'btn-sm',
                'text-uppercase',
                'lett-spacing-2',
                'w-25',
                'fw-bold'
            ]
        ]) ?>
    </div>
    <?= Html::endForm(); ?>
</div>