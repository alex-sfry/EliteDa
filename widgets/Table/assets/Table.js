document.querySelector(`#${container} .w-table thead tr:nth-child(2)`)
    .addEventListener('input', (e) => {
        if (!e.target.classList.contains('form-control')) return;
        const rows = document.querySelectorAll(`#${container} .w-table tbody tr`);
        const filterIndex = Array.from(e.currentTarget.children).indexOf(e.target.parentElement);

        for (let i = 0; i < rows.length; i++) {
            if (e.target.value === '') {
                rows[i].classList.remove(`hiddden-c-${filterIndex}`);
                continue;
            }

            const tds = rows[i].querySelectorAll('td');

            if (!tds[filterIndex].textContent.trim().toLowerCase().includes(e.target.value.toLowerCase())) {
                rows[i].classList.add(`hiddden-c-${filterIndex}`);
            } else {
                rows[i].classList.remove(`hiddden-c-${filterIndex}`);
            }
        }
    })

document.querySelector(`#${container} .w-table thead tr:nth-child(2)`)
    .addEventListener('change', (e) => {
        if (!e.target.classList.contains('form-select')) return;
        const rows = document.querySelectorAll(`#${container} .w-table tbody tr`);
        const filterIndex = Array.from(e.currentTarget.children).indexOf(e.target.parentElement);

        for (let i = 0; i < rows.length; i++) {
            if (e.target.value === '') {
                rows[i].classList.remove(`hiddden-c-${filterIndex}`);
                continue;
            }

            const tds = rows[i].querySelectorAll('td');
            
            if (tds[filterIndex].textContent.trim() !== e.target.value) {
                rows[i].classList.add(`hiddden-c-${filterIndex}`);
            } else {
                rows[i].classList.remove(`hiddden-c-${filterIndex}`);
            }
        }
    });