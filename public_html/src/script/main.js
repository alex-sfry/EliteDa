import '../styles/scss/style.scss';
// import '../styles/bootstrapSCSS/bootstrap.scss';
import {commoditiesForm} from './commodities.js';
import {tradeRouteForm} from './tradeRoutes.js';
import {isValidated} from './isValidated.js';

const initHeader = () => {
    document.querySelectorAll('.menu__link').forEach(item => {
        if (item.getAttribute('href') === window.location.pathname ||
            window.location.pathname.includes(item.getAttribute('href'))) {
            item.classList.add('active');
        } else item.classList.remove('active');
    });
};

const loader = (insertElem, hideElem) => {
    insertElem.insertAdjacentHTML(
        'afterend',
        "<div class='c-loading my-0 mx-auto text-light bg-light-orange rounded-2 p-2 fw-bold'>Loading . . .</div>"
    );

    if (hideElem) {
        hideElem.classList.add('d-none');
        document.querySelectorAll('.Zebra_Pagination').forEach( item => {
            item.classList.add('d-none');
        });
    }
};

const removeLoader = (elem) => {
    if (elem) {
        const loadingPlaceholder = document.querySelector('.c-loading');
        loadingPlaceholder && loadingPlaceholder.remove();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    if (document.querySelector('#c-form'))  commoditiesForm(loader, removeLoader);
    if (document.querySelector('#tr-form'))  tradeRouteForm(isValidated, loader, removeLoader);
});


