<?php

/**
 * @var yii\web\View $this
 * @var array $by_name_form_values
 */
use yii\helpers\Html;

use function app\helpers\d;
use function app\helpers\e;

$search_name_cls = !empty($errors) ? 'is-invalid' : null;
?>

<div>
    <?= Html::beginForm(
        '/systems/',
        'get',
        [
            'id' => 'sys-name-form',
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
        'sysName',
        ['class' => ['text-nowrap', 'fs-6', 'fw-bold', 'align-content-center']]
    ) ?>
    <div class="d-flex align-items-baseline gap-3">
        <div class="w-75">
            <?= Html::input('search', 'sysName', e($by_name_form_values['sysName']), [
                'id' => 'sysName',
                'name' => 'sysName',
                'required' => true,
                'class' => [
                    'form-control',
                    'form-control-sm',
                    'rounded-1',
                    'border-1',
                    $search_name_cls
                ]
            ]) ?>
            <div class="invalid-feedback fw-bold">
                <?= $errors['sysName'][0] ?? 'Field must not be empty' ?>
            </div>
        </div>
        <?= Html::button('search', [
            'type' => 'submit',
            'name' => 'sysNameBtn',
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