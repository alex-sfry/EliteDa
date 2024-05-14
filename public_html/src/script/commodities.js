import {Pagination} from './Pagination.js';
import {SortTable} from './SortTable.js';
import {Table} from './Table.js';

export const commoditiesForm = (loader, removeLoader, fetchData) => {
    const $form = $('#c-form');
    const $table = $('.c-table');
    const $pagination = $('.pagination');
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
        } else loader($form, $table);
    };

    $form.on('submit', handleSubmit);
    const table = new Table('c-table');

    const proxyHandler= {
        set(target, prop, val) {
            if (prop === "data") {
                table.fillTable(val.data, 'commodities');
                return true;
            }
            return true;
        },
    };

    const pagination = $pagination.length ?
        new Proxy(new Pagination(7, fetchData, $pagination.html(), table), proxyHandler) : null;
    const sortTable = $pagination.length ?
        new Proxy(new SortTable('.c-table', fetchData, table, pagination), proxyHandler) :
        new Proxy(new SortTable('.c-table', fetchData, table), proxyHandler);

    pagination && pagination.setEventListeners();
    sortTable && sortTable.setEventListeners();
};
