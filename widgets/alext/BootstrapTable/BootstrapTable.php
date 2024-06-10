<?php

namespace app\widgets\alext\BootstrapTable;

use Exception;
use yii\base\Widget;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

use function app\helpers\d;

class BootstrapTable extends Widget
{
    public array $models = [];
    public array $columns = [];
    public Pagination $pagination;
    public Sort $sort;
    public string $table_cls = 'c-table';
    public string $cnt_id = 'c-table';
    public string $pagination_id = 'pgr01';

    /**
     * @throws Exception
     */
    public function init(): void
    {
        // BootstrapTableAsset::register($this->getView());
        if (empty($this->columns)) {
            throw new Exception('The "columns" property must be set.');
        }

        if (!$this->pagination instanceof Pagination) {
            throw new Exception('The "pagination" property must be an instance of yii\data\Pagination.');
        }

        if (!$this->sort instanceof Sort) {
            throw new Exception('The "sort" property must be an instance of yii\data\Sort.');
        }

        BootstrapTableAsset::register($this->getView());
        parent::init();
    }

    public function run(): string
    {
        return $this->renderTable() . $this->renderPagination();
    }


    private function renderTable(): string
    {
        $headers = '';

        foreach ($this->columns as $column) {
            $label = $column['label'];
            $th_sortable_cls = null;

            if (isset($column['sortable']) && $column['sortable']) {
                $label = $this->sort->link(
                    $column['attribute'],
                    [
                        'label' => $label,
                        'class' => 'sort text-decoration-none w-100 h-100 px-1 py-2 text-primary d-flex 
                                    justify-content-between align-items-center'
                    ]
                );

                $th_sortable_cls = 'p-0';
            }

            $headers .= Html::tag(
                'th',
                $label,
                [
                    'class' => 'bg-secondary-subtle text-body text-nowrap ' . $th_sortable_cls,
                    'scope' => 'col',
                    'data-attr' =>  $column['attribute']
                ]
            );
        }

        $rows = '';

        foreach ($this->models as $model) {
            $row = '';

            foreach ($this->columns as $column) {
                $cls = null;

                if (isset($column['class'])) {
                    $cls = is_callable($column['class']) ? $column['class']($model) :  $column['class'];
                }

                if (isset($column['value'])) {
                    $value = is_callable($column['value']) ? $column['value']($model) : Html::encode($column['value']);
                } else {
                    $value = Html::encode($model[$column['attribute']]);
                }

                $row .= Html::tag(
                    'td',
                    $value,
                    ['class' => 'text-start text-truncate ' . $cls]
                );
            }

            $rows .= Html::tag('tr', $row);
        }

        return Html::tag(
            'div',
            Html::tag(
                'table',
                Html::tag('thead', Html::tag('tr', $headers)) . Html::tag('tbody', $rows),
                ['class' => $this->table_cls . ' bs-table fs-7 table table-striped mb-0 overflow-x-auto']
            ),
            [
                'class' => 'rounded-2 table-responsive',
                'id' => $this->cnt_id
            ]
        );
    }

    private function renderPagination(): string
    {
        $page_count = $this->pagination->getPageCount();
        $page_count_info = $page_count > 1 ? $page_count : null;

        return Html::tag(
            'div',
            $page_count_info .
            LinkPager::widget([
                'id' => $this->pagination_id,
                'pagination' => $this->pagination,
                'disableCurrentPageButton' => false,
                'maxButtonCount' => 7,
                'firstPageLabel' => 'first',
                'lastPageLabel' => 'last',
                'prevPageCssClass' => 'prev-page',
                'nextPageCssClass' => 'next-page'
            ]),
            [
                'class' => 'c-pagination-cnt d-flex justify-content-center align-items-center pb-4'
            ]
        );
    }

    private function getPageCounter(): string
    {
        /*calculations for pages info near pagination buttons*/
        $current_page = $this->pagination->getPage() + 1;
        $page_size = $this->pagination->getPageSize();
        $first_in_range = $page_size * $current_page - $page_size + 1;
        $last_in_range = $this->pagination->totalCount - ($current_page - 1) * $page_size <= $page_size - 1 ?
        $this->pagination->totalCount : $page_size * $current_page;

        return "<div class='page-counter text-light me-2 fs-7'>
                    $first_in_range - $last_in_range / {$this->pagination->totalCount}
                </div>";
    }
}
