<?php

/**
 * @var string $error
 * @var string $selected
 * @var string $placeholder
 * @var string $label_main
 * @var string $container
 * @var string $search
 * @var string $to_submit
 * @var string $endpoint
 * @var string $toggle_btn_text
 * @var bool $ajax
 * @var string $name_main
 * @var bool $radio_switch
 * @var string $label_switch1
 * @var string $label_switch2
 * @var string $name_radio
 * @var string $endpoint1
 * @var string $endpoint2
 * @var bool $required
 * @var string $selected_radio
 * @var string  $btn_position
 */

use yii\helpers\Html;

Yii::$app->view->registerJs(
    '
    if (typeof config === "undefined") {
        let configDd1911 = {
            container: "' . $container . '",
            search: "' . $search . '",
            toSubmit: "' . $to_submit . '" ,
            ajax: "' . $ajax . '",
            endpoint: "' . $endpoint . '",
            endpoint1: "' . $endpoint1 . '",
            endpoint2: "' . $endpoint2 . '",
            switchValue: "' . $selected . '",
            switchName1: "' . $label_switch1 . '",
            switchName2: "' . $label_switch2 . '"
        };

        document.addEventListener("DOMContentLoaded", () => {
            new InputDropdown(configDd1911);
        });
    } else {
        configDd1911 = {
            container: "' . $container . '",
            search: "' . $search . '",
            toSubmit: "' . $to_submit . '" ,
            ajax: "' . $ajax . '",
            endpoint: "' . $endpoint . '",
            endpoint1: "' . $endpoint1 . '",
            endpoint2: "' . $endpoint2 . '",
            switchValue: "' . $selected . '",
            switchName1: "' . $label_switch1 . '",
            switchName2: "' . $label_switch2 . '"
        };
        
        document.addEventListener("DOMContentLoaded", () => {
            new InputDropdown(configDd1911);
        });
    }
    ',
    yii\web\View::POS_END
);

$classes = [
    'w-100',
    'p-1',
    'border',
    'rounded-2',
    'shadow-none',
    'fw-normal',
    'sys-search',
    'mb-1',
];

$classes_radio = [
    'idd-switch',
    'form-check-input',
    'me-3',
    'ms-1',
    'shadow-none'
];

if (isset($error) && $error === 'is-invalid') {
    HTML::addCssClass($classes, 'is-invalid border-2 border-danger');
} else {
    HTML::addCssClass($classes, 'border-dark');
}
?>

<div id="<?= $container ?>" class="position-relative">
    <?php if ($radio_switch) : ?>
        <div>
            <label for="target-idd-search">
                <?= $label_main ?>
            </label>
            <div class="d-flex">
                <label class="min-lett-spacing fw-bold" for="target_<?= $label_switch1 ?>">
                    <?= $label_switch1 ?>
                </label>
                <?= HTML::radio(
                    $name_radio,
                    $selected_radio === 'system' && !str_contains($selected, ' / ') ||
                    $selected_radio === 'station' && $selected && !str_contains($selected, ' / '),
                    [
                        'class' => $classes_radio,
                        'id' => "target_$label_switch1",
                        'value' => $label_switch1,
                    ]
                ); ?>
                <label class="min-lett-spacing fw-bold" for="target_<?= $label_switch2 ?>">
                    <?= $label_switch2 ?>
                </label>
                <?= HTML::radio(
                    $name_radio,
                    $selected_radio === 'station' && str_contains($selected, ' / ') ||
                     $selected_radio === 'system' && $selected && str_contains($selected, ' / '),
                    [
                        'class' => $classes_radio,
                        'id' => "target_$label_switch2",
                        'value' => $label_switch2,
                    ]
                ); ?>
            </div>
        </div>
    <?php else : ?>
        <label class="min-lett-spacing fw-bold
        <?= $error === 'is-invalid' ? 'text-danger is-invalid' : '' ?>"
               for="<?= $search ?>">
            <?= $label_main ?>
        </label>
    <?php endif; ?>
    <div class="input-dd-selected-items d-flex">
        <div class="search-selected info bg-info px-1 py-1 lh-1 rounded-2
             <?= $selected === '' ? 'd-none' : '' ?>"
             id="idd-search-selected">
            <?= Html::encode($selected) ?>
        </div>
        <button type="button" id="reset-idd" class="reset-input-dd btn btn-link py-1 lh-1
            <?= Html::encode($selected) === '' ? 'd-none' : '' ?>">
            reset
        </button>
    </div>
    <div class='c-dropdown idd-dropdown dropdown-container d-input w-100'>
        <div
            class="dropdown <?= $btn_position === 'right' ? 'd-flex justify-content-end gap-1' : '' ?>">
            <?= Html::textInput(
                '',
                null,
                [
                    'class' => $classes,
                    'id' => $search,
                    'placeholder' => $placeholder,
                ]
            ) ?>
            <button id="idd-toggle"
                    class="btn btn-outline-dark btn-sm dropdown-toggle px-1 fw-normal bg-secondary-subtle w-100"
                    type='button'
                    data-bs-toggle='dropdown'
                    data-bs-auto-close='dropdown' aria-expanded='false'
                    style="<?= $btn_position === 'right' ? 'height: 34px' : '' ?>">
                <?= $toggle_btn_text ?>
            </button>
            <?= Html::textInput(
                $name_main,
                Html::encode($selected),
                [
                    'class' => ['d-none'],
                    'id' => $to_submit,
                    'required' => $required ? '' : null
                ]
            ) ?>
            <p class="invalid-feedback feedback position-absolute fw-bold mt-0 pt-0
            <?= $btn_position === 'right' ? 'btn-right-error' : '' ?>">
                Field must not be empty
            </p>
            <ul class='dropdown-menu border-dark-subtle px-1 w-100 me-2 shadow-sm visually-hidden overflow-y-auto
                            overflow-x-hidden text-truncate'></ul>
        </div>
    </div>
</div>
