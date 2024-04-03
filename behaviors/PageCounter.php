<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\data\Pagination;

class PageCounter extends Behavior
{
    /**
     * @param \yii\data\Pagination $pagination
     *
     * @return string
     */
    public function getPageCounter(Pagination $pagination): string
    {
        /*calculations for pages info near pagination buttons*/
        $current_page = $pagination->getPage() + 1;
        $page_size = $pagination->getPageSize();
        $first_in_range = $page_size * $current_page - $page_size + 1;
        $last_in_range = $pagination->totalCount - ($current_page - 1) * $page_size <= $page_size - 1 ?
            $pagination->totalCount : $page_size * $current_page;

        return "<div class='page-counter text-light me-2'>
                        $first_in_range-$last_in_range / $pagination->totalCount
                    </div>";
    }
}