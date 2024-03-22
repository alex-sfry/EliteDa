<?php

/**
 * @var string $error
 * @var array $selected
 * @var string $placeholder
 * @var string $label_main
 * @var string $container
 * @var string $search
 * @var string $to_submit
 * @var string $toggle_btn_text
 * @var string $name_main
 * @var array $list_items
 * @var string $required
 */

use yii\helpers\Html;

Yii::$app->view->registerJs(
    '
    if (typeof config === "undefined") {
        let configCs1911 = {
            container: "' . $container . '",
            search: "' . $search . '",
            toSubmit: "' . $to_submit . '",
            placeholder: "' . $placeholder . '"
        };
        
        document.addEventListener("DOMContentLoaded", () => {
            new CustomSelect(configCs1911);
        });
    } else {
        configCs1911 = {
            container: "' . $container . '",
            search: "' . $search . '",
            toSubmit: "' . $to_submit . '",
            placeholder: "' . $placeholder . '"
        };
        
        document.addEventListener("DOMContentLoaded", () => {
            new CustomSelect(configCs1911);
        });
    }
    ',
    yii\web\View::POS_END
);

$options = [];

foreach ($selected as $key => $value) {
    $options[$value] = $value;
}
?>

<div id="<?= $container ?>">
    <label class="fw-bold <?=  isset($error) && $error === 'is-invalid' ?
        'is-invalid text-danger' : '' ?>"
        for='c-hiddenSelect'>
        <?= $label_main ?>
    </label>
    <div class='c-select dropdown-container m-0 bg-transparent position-relative'>
        <?= Html::dropDownList(
            $name_main,
            $selected,
            $options,
            [
                'class' => [
                    'form-select',
                    'form-select-sm',
                    'd-none',
                    isset($error) && $error === 'is-invalid' ? 'is-invalid' : ''
                ],
                'id' => $to_submit,
                'multiple' => '',
                'required' => $required ? '' : null
            ]
        ) ?>
        <p class="invalid-feedback position-absolute fw-bold top-100">
            Field must not be empty
        </p>
        <div class='dropdown bg-transparent'>
            <div class="selected-items h-100 d-flex gap-1 flex-wrap w-100 border rounded-2 mb-1 px-1 bg-transparent
                fw-normal <?= isset($error) && $error === 'is-invalid' ?
                'is-invalid border-2 border-danger' : 'border-dark' ?>">
                <?php foreach ($selected as $item) : ?>
                    <div class="ps-1 rounded-2">
                        <?= Html::encode($item) ?>
                        <span class='border-start border-1 border-black lh-1'></span>
                        <button
                            class="close border-0 rounded-2 m-0 p-0"
                            type="button"
                            aria-label="Close">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="currentColor"
                                class="svg-close bi bi-x"
                                viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class='btn btn-outline-dark dropdown-toggle w-100 px-1 fw-normal bg-secondary-subtle'
                type='button'
                data-bs-toggle='dropdown'
                data-bs-auto-close='false'
                aria-expanded='false'>
                <?= $toggle_btn_text ?>
            </button>
            <div class="position-relative">
                <div class='dropdown-menu px-1 w-100 p-1 mt-1 shadow-sm'>
                    <?= Html::textInput(
                        '',
                        '',
                        [
                            'class' => ['form-control', 'bg-transparent', 'shadow-sm', 'border', 'border-2'],
                            'id' => $search,
                            'placeholder' => 'search'
                        ]
                    ); ?>
                    <ul class='c-list px-0 pt-2 pb-0 mb-0'>
                        <li class='dropdown-item fw-normal px-2 lh-1 h-0 m-0 p-0'></li>
                        <?php foreach ($list_items as $item) : ?>
                            <li class='c-list-item dropdown-item fw-normal px-2 h-0 m-0 p-0 overflow-x-hidden
                                text-truncate'>
                                <?= Html::encode($item) ?>
                            </li>
                        <?php endforeach; ?>
                        <?php unset($list_items) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
