import {handlePagination} from './handlePagination.js';

export const commoditiesForm = (loader, removeLoader) => {
    const form = document.querySelector('#c-form');
    const table = document.querySelector('.c-table');
    const pagination = document.querySelector('.pagination');
    removeLoader(table);

    const handleSubmit = (e) => {
        const form = document.querySelector('#c-form');

        if (!form.checkValidity()) {
            e.preventDefault();
        } else loader(form, table);
    };

    form.addEventListener('submit', (e) => handleSubmit(e));

    if (pagination) handlePagination('first', 'prev-page', 'next-page', 'last', 7);
};
