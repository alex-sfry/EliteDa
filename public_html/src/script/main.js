import '../styles/scss/style.scss';
// import '../styles/bootstrapSCSS/bootstrap.scss';
// import { fetchData } from './fetchData.js';
import { isValidated } from './isValidated.js';
import { commoditiesForm } from './commodities.js';
import { shipModulesForm } from './shipModules.js';
import { shipsForm } from './ships.js';
import { tradeRouteForm } from './tradeRoutes.js';
import { matTraders } from './matTraders.js';
import { cookiesConsent } from './cookiesConsent.js';
// import {getDataFromDom} from './addToDb.js';

cookiesConsent();

const initHeader = () => {
    $('.menu__link').each(function () {
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
    $insertElem.after("<div class='c-loading my-0 mx-auto text-light bg-info rounded-2 px-3 py-1 fw-bold'>" +
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

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initFooter();
    if ($('#c-form').length) commoditiesForm(loader, removeLoader);
    if ($('#mod-form').length) shipModulesForm(loader, removeLoader);
    if ($('#ships-form').length) shipsForm(isValidated, loader, removeLoader);
    if ($('#tr-form').length) tradeRouteForm(isValidated, loader, removeLoader);
    if ($('#mt-form').length) matTraders();

    $('#accordionForm .accordion-button').on('click', function () {
        if ($(this).text().trim() === 'Close form') {
            $(this).text('Open form');
        } else if ($(this).text().trim() === 'Open form') {
            $(this).text('Close form');
        }
    });

    if ($('#w0'.length > 0)) {
        const $filterBtns = $('.filters .btn');

        $filterBtns.on('click', function() {
            $filterBtns.prev().trigger('change.yiiGridView');
        });
 
        $('.filters input').on('change', function() {
            return false;
        });
    }

    // if ($('.add-to-db').length) getDataFromDom(fetchData);
});
