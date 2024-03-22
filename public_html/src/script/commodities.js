export const commoditiesForm = (loader, removeLoader) => {
    const form = document.querySelector('#c-form');
    const table = document.querySelector('.c-table');
    // const pagination = document.querySelector('.pagination');
    removeLoader(table);

    const handleSubmit = (e) => {
        const form = document.querySelector('#c-form');

        if (!form.checkValidity()) {
            e.preventDefault();
        } else loader(form, table);
    };

    // const handlePaginationClick = async (e) => {
    //     e.preventDefault();
    //
    //     try {
    //         let data = null;
    //         const res = await fetch(
    //             `/commodities/?page=5`, {
    //                 method: 'GET',
    //                 headers: {
    //                     contentType: 'application/json',
    //                 },
    //             });
    //
    //         if (res.ok) {
    //             data = await res.json();
    //             console.log(data);
    //         }
    //     }
    //     catch (error) {
    //         console.log(error.message);
    //     }
    // };

    form.addEventListener('submit', (e) => handleSubmit(e));
    // pagination.addEventListener('click', (e) => handlePaginationClick(e));

};
