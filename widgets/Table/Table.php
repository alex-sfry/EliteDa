<?php

namespace app\widgets\Table;

use yii\base\Widget;
use yii\helpers\VarDumper;

class Table extends Widget
{
    public string $container = '';
    public array $model = [];
    public array $columns = [];

    public function init(): void
    {
        TableAsset::register($this->getView());
        parent::init();
    }

    public function run(): string
    {
        return $this->render(
            'index',
            [
                'container' => $this->container,
                'model' => $this->removeArrayItem($this->model),
                'columns' => $this->columns,
                'column_labels' => $this->getColumnLabels(),
                'column_filters' => $this->getFilter(),
            ]
        );
    }

    private function removeArrayItem($arr): array
    {
        return array_map(function ($item) {
            unset($item['market_id']);
            return $item;
        }, $arr);
    }

    private function getColumnLabels(): array
    {
        $labels = [];

        foreach ($this->columns as $column) {
            $labels[] = isset($column['label']) ? $column['label'] : $column['attribute'];
        }

        return $labels;
    }

    private function getFilter(): array
    {
        $filters = [];

        foreach ($this->columns as $column) {
            if (!isset($column['filterInputOptions'])) {
                $filters[] = '';
                continue;
            }

            switch ($column['filterInputOptions']['class']) {
                case 'form-select':
                    $elem = "<select class='{$column['filterInputOptions']['class']} w-auto py-1 fs-7' name='' id='' 
                            style='box-shadow: none;border-color: var(--bs-gray-300);'>";
                    foreach ($column['filter'] as $key => $value) {
                        $elem .= "<option value='$key'>$value</option>";
                    }
                    $elem .= "</select>";
                    $filters[] = $elem;
                    break;

                case 'form-control':
                    $filters[] = "<input class='{$column['filterInputOptions']['class']} w-auto py-1 fs-7' 
                                type='text' style='box-shadow: none;border-color: var(--bs-gray-300);'>";
                    break;
            }
        }

        return $filters;
    }
}
