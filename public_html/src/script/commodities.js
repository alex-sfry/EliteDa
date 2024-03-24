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

    const handlePagination = (id, first, prev, next, last) => {
        const firstPageBtn = document.querySelector(`#${id} .page-item.${first} > .page-link`);
        const lastPageBtn = document.querySelector(`#${id} .page-item.${last} > .page-link`);
        const prevPageBtn = document.querySelector(`#${id} .page-item.${prev} > .page-link`);
        const nextPageBtn = document.querySelector(`#${id} .page-item.${next} > .page-link`);

        const removeStaticBtns = (btns) => {
            btns.splice(0, 2);
            btns.splice(-2, 2);

            return btns;
        };

        const getPageBtns = () => {
            return Array.from(document.querySelectorAll(`#${id} .page-item > .page-link`));
        };

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

        const renderNewPageBtns = (links, page, lastPage) => {
            document.querySelectorAll('li.disabled').forEach(item => {
                item.classList.remove('disabled');
                item.classList.remove('active');
            });

            prevPageBtn.setAttribute('href', `${links.prev}`);
            nextPageBtn.setAttribute('href', `${links.next}`);

            if (links.self !== links.last && links.self !== links.first) {
                removeStaticBtns(getPageBtns()).forEach((item, index) => {
                    if (page + 2 < lastPage && page - 2 >= 1) {
                        console.log('page', page);
                        item.textContent = page - 2 + index;
                        item.setAttribute('data-page', page - 2 + index);
                    } else if (page - 2 < 1) {
                        console.log('page', page);
                        item.setAttribute('data-page', page - 1 + index);
                    } else if (page + 2 > lastPage) {
                        console.log('page', page)
                        item.textContent = page - 3 + index;
                        item.setAttribute('data-page', page - 3 + index);
                    }

                    item.setAttribute('href', `${links.first.substring(0, links.first.length - 1)}${item.textContent}`);
                });

                document.querySelector(`[data-page='${page}']`).parentElement.classList.add('active', 'disabled');
            } else if (links.self === links.first) {
                console.log('page', page);
                removeStaticBtns(getPageBtns()).forEach((item, index) => {
                    firstPageBtn.parentElement.classList.add('disabled');
                    prevPageBtn.parentElement.classList.add('disabled');
                    item.textContent = page + index;
                    item.setAttribute('data-page', page + index);
                    item.setAttribute('href', `${links.first.substring(0, links.first.length - 1)}${item.textContent}`);
                });

                document.querySelector(`[data-page='${page}']`).parentElement.classList.add('active', 'disabled');
            } else if (links.self === links.last) {
                console.log('page', page);
                removeStaticBtns(getPageBtns()).forEach((item, index) => {
                    lastPageBtn.parentElement.classList.add('disabled');
                    nextPageBtn.parentElement.classList.add('disabled');

                    item.textContent = page - 4 + index;
                    item.setAttribute('data-page', page - 4 + index);
                    item.setAttribute('href', `${links.first.substring(0, links.first.length - 1)}${item.textContent}`);
                });

                document.querySelector(`[data-page='${page}']`).parentElement.classList.add('active', 'disabled');
            }
        };

        const handleClick = async (e) => {
            e.preventDefault();
            const res = await getNewPagaData(e.currentTarget.getAttribute('href'));
            renderNewPageBtns(res.links, res.page + 1, res.lastPage);
        };

        getPageBtns().forEach(item => item.addEventListener('click', handleClick));
    };

    form.addEventListener('submit', (e) => handleSubmit(e));

    if (pagination) {
        handlePagination('pgr01', 'first', 'prev-page', 'next-page', 'last');
        handlePagination('pgr02', 'first', 'prev-page', 'next-page', 'last');
    }
};
