<?php

namespace app\widgets\CustomSelect;

use yii\base\Widget;

class CustomSelect extends Widget
{
    public array $selected = [];
    public string $error = '';
    public string $container = '';
    public string $to_submit = '';
    public string $search = '';
    public string $placeholder = '';
    public string $label_main = '';
    public string $toggle_btn_text = '';
    public string $name_main = '';
    public array $list_items = [];
    public string $required = '';
    public string $filter_method = 'startsWith';

    public function init(): void
    {
        CustomSelectAsset::register($this->getView());
        parent::init();
    }

    public function run(): string
    {
        return $this->render(
            'index',
            [
                'selected' => $this->selected,
                'error' => $this->error,
                'container' => $this->container,
                'search' => $this->search,
                'to_submit' => $this->to_submit,
                'placeholder' => $this->placeholder,
                'label_main' => $this->label_main,
                'toggle_btn_text' => $this->toggle_btn_text,
                'name_main' => $this->name_main,
                'list_items' => $this->list_items,
                'required' => $this->required,
                'filter_method' => $this->filter_method
            ]
        );
    }
}
