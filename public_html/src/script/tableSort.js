import {fetchData} from './fetchData.js';

export const tableSort = async (cnt, handlePagination = null, paginationHTML = null) => {
    const resetPagination = (limit, totalCount) => {
        $('.pagination').html(paginationHTML);
        $('.page-counter').text(`${0 * limit + 1} - ${1 * limit} / ${totalCount}`);
        handlePagination('first', 'prev-page', 'next-page', 'last', 7);
    };
    const renderData = (data) => {

    };

    async function handleClick(e) {
        e.preventDefault();
        const data = await fetchData($(this).attr('href'));
        console.log(data);
        handlePagination && resetPagination(data.limit, data.totalCount);
        $('a.sort').removeClass(['asc', 'desc', 'sorted']);

        if (Object.values(data.attributeOrders)[0] === 4) {
            $(this).addClass(['sorted', 'asc']);
        } else $(this).addClass(['sorted', 'desc']);

        $(this).attr('href', data.sortUrl);
        renderData(data);
    }

    const setEventListeners = () => $(cnt + ' .sort').on('click', handleClick);
    setEventListeners();
};
