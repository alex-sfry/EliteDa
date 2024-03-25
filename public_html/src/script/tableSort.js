import {fetchData} from './fetchData.js';
// import {handlePagination} from './handlePagination.js';

export const tableSort = async (cnt, handlePagination, paginationHTML = null) => {
    const sortableColumns = document.querySelectorAll('a.sort');

    const resetPagination = (limit, totalCount) => {
        document.querySelectorAll('.pagination').forEach(item => item.innerHTML = paginationHTML);
        document.querySelectorAll('.page-counter').forEach(item => {
            item.textContent = `${0 * limit + 1} - ${1 * limit} / ${totalCount}`;
        });

        handlePagination('first', 'prev-page', 'next-page', 'last', 7);
    };
    const renderData = (data) => {

    };

    const handleClick = async (e) => {
        e.preventDefault();
        const sortLinkElem = e.currentTarget;
        const data = await fetchData(`${sortLinkElem.getAttribute('href')}`);
        console.log(data);
        paginationHTML && resetPagination(data.limit, data.totalCount);
        sortableColumns.forEach(item => item.classList.remove('asc', 'desc', 'sorted'));

        if (Object.values(data.attributeOrders)[0] === 4) {
            sortLinkElem.classList.add('sorted', 'asc');
        } else sortLinkElem.classList.add('sorted', 'desc');

        sortLinkElem.setAttribute('href', data.sortUrl);
        renderData(data);
    };

    const setEventListeners = () => {
        document.querySelectorAll(`${cnt} .sort`).forEach(item => item.addEventListener('click', handleClick));
    };

    setEventListeners();
};
