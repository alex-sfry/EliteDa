import '../styles/scss/style.scss';
// import '../styles/bootstrapSCSS/bootstrap.scss';
import {fetchData} from './fetchData.js';
import {commoditiesForm} from './commodities.js';
import {tradeRouteForm} from './tradeRoutes.js';
import {isValidated} from './isValidated.js';

const initHeader = () => {
    $('.menu__link').each(function() {
        if ($(this).attr('href') === window.location.pathname ||
            window.location.pathname.includes($(this).attr('href'))) {
            $(this).addClass('active');
        } else $(this).removeClass('active');
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

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    if ($('#c-form').length)  commoditiesForm(loader, removeLoader, fetchData);
    if ($('#tr-form').length)  tradeRouteForm(isValidated, loader, removeLoader, fetchData);
});


