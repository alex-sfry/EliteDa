import { Pagination } from './Pagination.js';
import { SortTable } from './SortTable.js';
import { Table } from './Table.js';

const $table = $('.bs-table');
const $pagination = $('.pagination');

const $table_columns = [];

$('.c-table th').each(function () {
    $table_columns.push($(this).attr('data-attr'))
});

const table = new Table('c-table', $table_columns);

const proxyHandler = {
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
    new Proxy(new SortTable('.c-table', fetchData, table, pagination), proxyHandler) :
    new Proxy(new SortTable('.c-table', fetchData, table), proxyHandler);

pagination && pagination.setEventListeners();
sortTable && sortTable.setEventListeners();

async function fetchData (url, method = 'GET', body= null, loaderCnt = null) {
    function enableLoader(loaderCnt) {
        if (loaderCnt !== '') $(loaderCnt).addClass('opacity-25');
    }
    
    function disableLoader(loaderCnt) {
        $(loaderCnt).removeClass('opacity-25');
    }

    loaderCnt && enableLoader(loaderCnt);

    try {
        const res = await fetch(
            url, {
                method: method,
                mode: 'cors', // this cannot be 'no-cors'
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: body
            });
        if (res.ok) {
            return await res.json();
        } else {
            console.log('fetch error');
        }
    }
    catch (error) {
        console.log(error.message);
    }
    finally {
        loaderCnt && disableLoader(loaderCnt);
    }
};
