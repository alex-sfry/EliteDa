<?php

namespace app\widgets\pagecounter;

use app\widgets\alext\pagecounter\PageCounterAsset;
use Exception;
use yii\base\Widget;
use yii\data\Pagination;

class PageCounter extends Widget
{
    public ?Pagination $pagination = null;
    public string $class;

    /**
     * @throws Exception
     */
    public function init(): void
    {
        if (!$this->pagination || !$this->pagination instanceof Pagination) {
            throw new Exception('Pagination object is missing');
        }

        PageCounterAsset::register($this->getView());
        parent::init();
    }

    public function run(): string
    {
        return $this->renderPageCounter();
    }

    protected function renderPageCounter(): string
    {
        /*calculations for pages info near pagination buttons*/
        $current_page = $this->pagination->getPage() + 1;
        $page_size = $this->pagination->getPageSize();
        $first_in_range = $page_size * $current_page - $page_size + 1;
        $last_in_range = $this->pagination->totalCount - ($current_page - 1) * $page_size <= $page_size - 1 ?
        $this->pagination->totalCount : $page_size * $current_page;
        // 'page-counter text-light me-2 fs-7'
        return "<div class='{$this->class}'>
                    $first_in_range - $last_in_range / {$this->pagination->totalCount}
                </div>";
    }
}
