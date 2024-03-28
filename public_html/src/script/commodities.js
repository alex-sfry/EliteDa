import {Pagination} from './Pagination.js';
import {SortTable} from './SortTable.js';

export const commoditiesForm = (loader, removeLoader, fetchData) => {
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

    const proxyHandler={
        set(target, prop, val) {
            if (prop === "data") {
                console.log(val);
                return val;
            }
        },
    };

    const pagination = $pagination.length ?
        new Proxy(new Pagination(7, fetchData, $pagination.html()), proxyHandler) : null;
    const sortTable = $pagination.length ?
        new Proxy(new SortTable('.c-table', fetchData, pagination), proxyHandler) : null;

    pagination.setEventListeners();
    sortTable.setEventListeners();
};
