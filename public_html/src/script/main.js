import '../styles/scss/style.scss';
// import '../styles/bootstrapSCSS/bootstrap.scss';
import {fetchData} from './fetchData.js';
import {isValidated} from './isValidated.js';
import {commoditiesForm} from './commodities.js';
import {tradeRouteForm} from './tradeRoutes.js';
import {matTraders} from './matTraders.js';

const initHeader = () => {
    $('.menu__link').each(function() {
        if ($(this).attr('href') === window.location.pathname ||
            window.location.pathname.includes($(this).attr('href'))) {
            $(this).addClass('active');
            $(this).closest('.menu__item').children('.menu__link').addClass('active');
        } else {
            $(this).removeClass('active');
            $(this).closest('.menu__link').removeClass('active');
        }
    });
};

const loader = ($insertElem, $hideElem) => {
    $insertElem.after("<div class='c-loading my-0 mx-auto text-light bg-light-orange rounded-2 p-2 fw-bold'>" +
        "Loading . . .</div>");

    if ($hideElem.length) {
        $hideElem.addClass('d-none');
        $('.c-pagination-cnt').addClass('d-none');
        $('.c-result-legend').addClass('d-none');
    }
};

const removeLoader = ($elem) => {
    if ($elem.length) {
        const $loadingPlaceholder = $('.c-loading');
        $loadingPlaceholder.length && $loadingPlaceholder.remove();
    }
};

const getMaterialsFromTable = async () => {
    const table = [];

    $('#encoded tbody tr').each(function() {
        table.push({
            name: $(this).find('th').text().trim(),
            category: $(this).find('td').eq(0).text().trim(),
            grade: $(this).find('td').eq(1).text().trim(),
            type: 'encoded',
            location: ''
        });
    });

    $('#manf tbody tr').each(function() {
        table.push({
            name: $(this).find('th').text().trim(),
            category: $(this).find('td').eq(0).text().trim(),
            grade: $(this).find('td').eq(1).text().trim(),
            type: 'manufactured',
            location: $(this).find('td').eq(2).text().trim(),
        });
    });

    $('#raw tbody tr').each(function() {
        table.push({
            name: $(this).find('th').text().trim(),
            category: $(this).find('td').eq(0).text().trim(),
            grade: $(this).find('td').eq(1).text().trim(),
            type: 'raw',
            location: $(this).find('td').eq(2).text().trim(),
        });
    });

    console.log(table);

    $('#addToDb').on('click', async function() {
    const url = '/addtodb-insert';

        try {
            console.log('ok');
            const res = await fetch(
                url, {
                    method: 'POST',
                    mode: 'cors', // this cannot be 'no-cors'
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(table),
                });
            if (res.ok) {
                console.log(await res.json());
                // return await res.json();
            } else {
                console.log('fetch error');
            }
        }
        catch (error) {
            console.log(error.message);
        }
    });
};


document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    if ($('#c-form').length)  commoditiesForm(loader, removeLoader, fetchData);
    if ($('#tr-form').length)  tradeRouteForm(isValidated, loader, removeLoader);
    if ($('#mt-form').length)  matTraders();

    $('#accordionForm .accordion-button').on('click', function() {
        if ($(this).text().trim() === 'Close form') {
            $(this).text('Open form');
        } else if ($(this).text().trim() === 'Open form') {
            $(this).text('Close form');
        }
    });

    if ($('table.article-table').length) getMaterialsFromTable();
});
