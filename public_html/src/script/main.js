import '../styles/scss/style.scss';
// import '../styles/bootstrapSCSS/bootstrap.scss';
import { validate } from './isValidated.js';
import { tradeRouteForm } from './tradeRoutes.js';
import { matTraders } from './matTraders.js';
import { cookiesConsent } from './cookiesConsent.js';
import { initTSelect } from './tSelect.js';
import { getSortIcon } from "./sortIcons.js";

cookiesConsent();

const initHeader = () => {
    $('.menu__link').each(function () {
        if ($(this).attr('href') === window.location.pathname) {
            $(this).addClass('active');
            $(this).closest('.menu__item').children('.menu__link').addClass('active');
        } else {
            $(this).removeClass('active');
            $(this).closest('.menu__link').removeClass('active');
        }
    });
};

const initFooter = () => {
    $('.footer__link').each(function () {
        if ($(this).attr('href') === window.location.pathname ||
            window.location.pathname.includes($(this).attr('href'))) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
};

const loader = ($insertElem, $hideElem) => {
    $insertElem.after(
        "<div class='row justify-content-center'>" +
        "<div class='c-loading my-0 mx-auto text-light bg-info rounded-2 px-3 py-1 fw-bold'>" +
        "Loading . . ." +
        "</div>" +
        "</div>"
    );

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

const handleSubmit = function (e) {
    if ($('#tr-form').length) return;

    if (!this.checkValidity()) {
        e.preventDefault();
        $(this).addClass("was-validated");
    } else loader($('.accordion').last(), $('table.c-table'));
};

$('form').on("submit", handleSubmit);

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initFooter();
    if ($('#c-form').length) removeLoader($('table'));
    if ($('#mod-form').length) removeLoader($('table'));
    if ($('#ships-form').length) removeLoader($('table'));
    if ($('#tr-form').length) tradeRouteForm(validate, loader, removeLoader);
    if ($('#mt-form').length) matTraders();

    if ($('.get-form').length) removeLoader($('table'));
    if ($('.t-sel').length) initTSelect('#refSystem');
    if ($('#rings-form').length) {
        removeLoader($('table'));
    }

    // accordion - switch title 
    $('#accordionForm .accordion-button').on('click', function () {
        if ($(this).text().trim() === 'Close form') {
            $(this).text('Open form');
        } else if ($(this).text().trim() === 'Open form') {
            $(this).text('Close form');
        }
    });

    // sorting table
    $('table th.sortable > a').each(function () {
        const $elem = $(this);
        $elem.hasClass('asc') && $elem.append(getSortIcon('asc'));
        $elem.hasClass('desc') && $elem.append(getSortIcon('desc'));
        !$elem.hasClass('asc') && !$elem.hasClass('desc') && $elem.append(getSortIcon('hourGlass'));
    });

    // gridview
    if ($('#w0'.length > 0)) {
        const $filterBtns = $('.filters .btn');

        $filterBtns.on('click', function () {
            $filterBtns.prev().trigger('change.yiiGridView');
        });

        $('.filters input').on('change', function () {
            return false;
        });
    }

    // if ($('.add-to-db').length) getDataFromDom(fetchData);
});
