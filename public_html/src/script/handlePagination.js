import {fetchData} from './fetchData.js';

export const handlePagination = (first, prev, next, last, pageBtnQty) => {
    const getCurrentDataPage = () => $('li.active > a').attr('data-page');

    const renderData = (data) => {

    };

    const renderNewPageBtns = (links, next, last, current, totalCount, limit, setEventListeners) => {
        const $pageNumBtns = $('li > .page-link');
        const pageBtnFirstNum = parseInt($pageNumBtns.eq(2).attr('data-page')) + 1;
        const pageBtnLastNum = parseInt($pageNumBtns.eq($pageNumBtns.length - 3).attr('data-page')) + 1;
        const clsBegin = next === 1 ? 'page-link disabled' : 'page-link';
        const clsEnd = next === last ? 'page-link disabled' : 'page-link';

        let html =
            `<li class="page-item first"><a class="${clsBegin}" href="${links.first}" data-page="0">first</a></li>`;
        html +=
            `<li class="page-item prev-page">
                    <a class="${clsBegin}" href="${links.prev}" data-page="${next - 1}">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>`;

        for (let i = 0; i < pageBtnQty; i++) {
            const href = links.first.substring(0, links.first.length - 1);
            let pageNum;

            if (next > current) {
                if (next >= last - 1) {
                    pageNum = last - (pageBtnQty - 1) + i;
                } else pageNum = pageBtnLastNum - next < 2 ? (next - (pageBtnQty - 3)) + i : pageBtnFirstNum + i;
            } else {
                if (next <= 2) {
                    pageNum = 1 + i;
                } else pageNum = next - pageBtnFirstNum < 2 ? (next - 2) + i : pageBtnFirstNum + i;
            }

            const cls = pageNum === next ? 'page-item active' : 'page-item';
            html +=
                `<li class="${cls}">
                        <a class="page-link" href="${href}${pageNum}" data-page="${pageNum - 1}">${pageNum}</a>
                    </li>`;
        }
        html +=
            `<li class="page-item next-page">
                    <a class="${clsEnd}" href="${links.next}" data-page="${next - 1}">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>`;
        html +=
            `<li class="page-item last">
                    <a class="${clsEnd}" href="${links.last}" data-page="${last - 1}">last</a>
                </li>`;

        $('.pagination').html(html);
        $('.page-counter').text(`${getCurrentDataPage() * limit + 1} 
       - ${next * limit < totalCount ? next * limit : totalCount} / ${totalCount}`);

        setEventListeners();
    };

    async function handleClick(e) {
        e.preventDefault();
        if ($(this).parent().is('.active')) return;
        const res = await fetchData($(this).attr('href'));
        console.log(res);
        renderNewPageBtns(
            res.links,
            res.page + 1, // zero based next page received from backend + 1
            res.lastPage,
            getCurrentDataPage(), // zero based current page
            res.totalCount,
            res.limit, // qty per page
            setEventListeners,
        );

        renderData(res);
    }

    const setEventListeners = () => $('.page-item > .page-link').on('click', handleClick);
    setEventListeners();
};
