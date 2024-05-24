import {Pagination} from './Pagination.js';
import {SortTable} from './SortTable.js';
import {Table} from './Table.js';

export const shipsForm = (isValidated, loader, removeLoader, fetchData) => {
    const $form = $('#ships-form');
    const $table = $('.ships-table');
    const $pagination = $('.pagination');
    const shipSelectLabel = $('label[for=\'c-hiddenSelect\']').get(0);
    const shipSelect = $('#c-hiddenSelect').get(0);
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
        } else loader($form, $table);

        isValidated(shipSelect, shipSelectLabel);
    };

   

    $form.on('submit', handleSubmit);
    const table = new Table(
        'ships-table',
        [
            'ship',
            'station',
            'type',
            'pad',
            'system',
            'distance_ly',
            'distance_ls',
            'price',
            'time_diff'
        ]
    );

    const proxyHandler= {
        set(target, prop, val) {
            if (prop === "data") {
                table.fillTable(val.data);
                return true;
            }
            return true;
        },
    };

    const pagination = $pagination.length ?
        new Proxy(new Pagination(7, fetchData, $pagination.html(), table), proxyHandler) : null;
    const sortTable = $pagination.length ?
        new Proxy(new SortTable('.ships-table', fetchData, table, pagination), proxyHandler) :
        new Proxy(new SortTable('.ships-table', fetchData, table), proxyHandler);

    pagination && pagination.setEventListeners();
    sortTable && sortTable.setEventListeners();
};
