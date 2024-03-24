export const handlePagination = (first, prev, next, last, pageBtnQty) => {
    const pagination = document.querySelectorAll('.pagination');
    const getCurrentDataPage = () => document.querySelector('li.active > a').getAttribute('data-page');

    const getNewPagaData = async (url) => {
        try {
            const res = await fetch(
                url, {
                    method: 'GET',
                    headers: {
                        contentType: 'application/json',
                    },
                });
            if (res.ok) {
                return await res.json();
            }
        }
        catch (error) {
            console.log(error.message);
        }
    };

    const renderNewPageBtns = (links, next, last, current, totalCount, limit, setEventListeners) => {
        const pageCounter = document.querySelectorAll('.page-counter');
        const pageNumBtns = Array.from(document.querySelectorAll(`li > .page-link`));
        const pageBtnFirstNum = parseInt(pageNumBtns[2].getAttribute('data-page')) + 1;
        const pageBtnLastNum = parseInt(pageNumBtns[pageNumBtns.length - 3 ].getAttribute('data-page')) + 1;
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

        for (let i = 0 ; i < pageBtnQty; i++) {
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

        pagination.forEach(item => item.innerHTML = html);
        pageCounter.forEach(item => item.textContent =
            `${getCurrentDataPage() * limit + 1} - ${next * limit < totalCount ? next * limit : 
                totalCount} / ${totalCount}`);
        setEventListeners();
    };

    const handleClick = async (e) => {
        e.preventDefault();
        if (e.currentTarget.parentElement.classList.contains('active')) return;
        const res = await getNewPagaData(e.currentTarget.getAttribute('href'));
        console.log(res);
        renderNewPageBtns(
            res.links,
            res.page + 1, // zero based next page received from backend + 1
            res.lastPage,
            getCurrentDataPage(), // zero based current page
            res.totalCount,
            res.limit, // qty per page
            setEventListeners
        );
    };

    const setEventListeners = () => {
        document.querySelectorAll(`.page-item > .page-link`)
                .forEach(item => item.addEventListener('click', handleClick));
    };
    setEventListeners();
};
