import {handlePagination} from './handlePagination.js';
import {tableSort} from './tableSort.js';

export const commoditiesForm = (loader, removeLoader) => {
    const $form = $('#c-form');
    const $table = $('.c-table');
    const $pagination = $('.pagination');
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form[0].checkValidity()) {
            e.preventDefault();
        } else loader($form, $table);
    };

    $form.on('submit', handleSubmit);
    if ($pagination.length) handlePagination('first', 'prev-page', 'next-page', 'last', 7);
    if ($table.length) tableSort('.c-table', handlePagination, $pagination.html());
};
