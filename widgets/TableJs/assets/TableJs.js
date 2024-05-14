class TableJs {
    constructor(container) {
        if (!container) return console.log('provide container for table');
        this.container = container;
        this.initTableJs();
    }

    filterOut(i, rows, filterIndex, filteredOut) {
        if (filteredOut) {
            rows[i].classList.add(`hiddden-c-${filterIndex}`);
        } else {
            rows[i].classList.remove(`hiddden-c-${filterIndex}`);
        }
    }

    initFilter(e) {
        const rows = document.querySelectorAll(`#${this.container} .w-table tbody tr`);
        const filterIndex = Array.from(e.currentTarget.children).indexOf(e.target.parentElement);

        for (let i = 0; i < rows.length; i++) {
            if (e.target.value === '') {
                rows[i].classList.remove(`hiddden-c-${filterIndex}`);
                continue;
            }

            const tds = rows[i].querySelectorAll('td');

            e.target.classList.contains('form-control') &&
                this.filterOut (
                    i, rows, filterIndex,
                    !tds[filterIndex].textContent.trim().toLowerCase().includes(e.target.value.toLowerCase())
                );
            e.target.classList.contains('form-select') && 
                this.filterOut (i, rows, filterIndex, tds[filterIndex].textContent.trim() !== e.target.value);
        }
    }

    initTableJs() {
        document.querySelector(`#${this.container} .w-table thead tr:nth-child(2)`)
            .addEventListener('input', (e) => {
                if (e.target.classList.contains('form-control')) this.initFilter(e);
            })

        document.querySelector(`#${this.container} .w-table thead tr:nth-child(2)`)
            .addEventListener('change', (e) => {
                if (e.target.classList.contains('form-select')) this.initFilter(e);
            })
    }
}