<?php

namespace app\widgets\InputDropdown;

use yii\base\Widget;

class InputDropdown extends Widget
{
    public string $selected = '';
    public string $error = '';
    public string $container = '';
    public string $to_submit = '';
    public string $ajax = '';
    public string $endpoint = '';
    public string $search = '';
    public string $placeholder = '';
    public string $label_main = '';
    public string $toggle_btn_text = '';
    public string $name_main = '';
    public bool $radio_switch = false;
    public string $label_switch1 = '';
    public string $label_switch2 = '';
    public string $name_radio = '';
    public string $selected_radio = '';
    public string $endpoint1 = '';
    public string $endpoint2 = '';
    public bool $required = false;
    public string $btn_position = '';
    public string $input_bg = '';

    public function init(): void
    {
        InputDropdownAsset::register($this->getView());
        parent::init();
    }

    public function run()
    {
        return $this->render(
            'index',
            [
                'selected' => $this->selected,
                'error' => $this->error,
                'container' => $this->container,
                'search' => $this->search,
                'to_submit' => $this->to_submit,
                'ajax' => $this->ajax,
                'endpoint' => $this->endpoint,
                'placeholder' => $this->placeholder,
                'label_main' => $this->label_main,
                'toggle_btn_text' => $this->toggle_btn_text,
                'name_main' => $this->name_main,
                'radio_switch' => $this->radio_switch,
                'label_switch1' => $this->label_switch1,
                'label_switch2' => $this->label_switch2,
                'name_radio' => $this->name_radio,
                'selected_radio' => $this->selected_radio,
                'endpoint1' => $this->endpoint1,
                'endpoint2' => $this->endpoint2,
                'required' => $this->required,
                'btn_position' => $this->btn_position,
                'input_bg' => $this->input_bg
            ]
        );
    }
}
