class InputDropdown {
    constructor(config) {
        if (!config) return console.log('provide config for InputDropdown');
        this.config = config;

        this.dropdownList = document.querySelector(`#${config.container} .dropdown-menu`);
        this.ddSearch = document.querySelector(`#${config.search}`);
        this.selected = document.querySelector(`#${config.container} #idd-search-selected`);
        this.label = document.querySelector(`#${config.container} label[for=${config.search}]`);
        this.toSubmit = document.querySelector(`#${config.toSubmit}`);
        this.ddToggle = document.querySelector(`#${config.container} #idd-toggle`);
        this.resetBtn = document.querySelector(`#${config.container} #reset-idd`);
        this.ddLisItems = [];
        this.endpoint = config.endpoint ? config.endpoint : null;
        this.switchValue = config.switchValue;
        this.form = this.toSubmit.closest('form');
        this.getListItems = config.ajax === '1' ? this.ddListFillFetch : null

        /**
         * // local state to prevent fetch on dropdown close (click to close)
         *  and to force request on switch value change
         */
        this.searchValue = '';
        this.lastSearchValue = '';
        this.lastSwitchValue = '';
        /**
         */

        this.setEventListeners();
    }

    async ddListFillFetch(searchValue, endpoint) {
        try {
            let data = null;
            const res = await fetch(
                `${endpoint}${searchValue.trim()}`, {
                    method: 'GET',
                    mode: 'cors', // this cannot be 'no-cors'
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

            if (res.ok) {
                data = await res.json();
            }

            if (data) {
                if (data.length <= 1) {
                    if (data.length === 0) return [];

                    if (Object.values(data[0]).length > 1) {
                        return [Object.values(data[0]).join(' / ')];
                    } else return Object.values(data[0]);
                }

                return data.map(item => {
                    if (Object.keys(item).length > 1) {
                        return Object.values(item).join(' / ');
                    } else return Object.values(item);
                });
            }
        }
        catch (error) {
            console.log(error.message);
        }
    };

    handleDropdownItemClick(e) {
        if (!e.target.classList.contains('form-dropdown')) return;
        if (e.target.textContent.trim() === this.selected.textContent) return;

        this.toSubmit.value = e.target.textContent;
        this.selected.textContent = e.target.textContent;
        this.selected.classList.remove('d-none');
        this.resetBtn.classList.remove('d-none');
        this.makeVisibleListItem();
        [...this.dropdownList.querySelectorAll('li')]
            .find(item => item.textContent === e.target.textContent).classList.add('d-none');
        this.searchValue = this.ddSearch.value;
    };

    async handleDropdownInput() {
        if (!this.dropdownList.classList.contains('show')) return;

        if (!this.ddSearch.value) {
            this.dropdownList.querySelectorAll('li').length <= 1 &&
            this.dropdownList.classList.add('visually-hidden');
            return;
        }

        if (this.ddSearch.value === this.searchValue) {
            if (this.dropdownList.querySelectorAll('li').length <= 1) {
                return this.showNotFound();
            }
        }

        if (this.ddSearch.value.length < 2) {
            this.dropdownList.classList.add('visually-hidden');
            this.dropdownList.innerHTML = '';
            return;
        }

        if (this.config.ajax) {
            const radioSwitch = document.querySelectorAll(`#${this.config.container} .idd-switch`);

            if (radioSwitch.length > 0) {
                if (!radioSwitch[0].checked && !radioSwitch[1].checked) return;
                if (radioSwitch[0].checked) this.switchValue = this.config.switchName1;
                if (radioSwitch[1].checked) this.switchValue = this.config.switchName2;

                switch (this.switchValue) {
                    case this.config.switchName1 :
                        this.endpoint = this.config.endpoint1;
                        break;
                    case this.config.switchName2 :
                        this.endpoint = this.config.endpoint2;
                        break;
                }
            }

            if (this.config.switch && !this.endpoint) return;
            if (this.ddSearch.value === this.lastSearchValue && this.lastSwitchValue === this.switchValue) return;

            this.dropdownList.classList.add('visually-hidden');
            this.ddLisItems = await this.getListItems(this.ddSearch.value, this.endpoint);
            this.dropdownList.classList.remove('visually-hidden');
            if (this.ddLisItems.length < 1) {
                this.lastSearchValue = this.ddSearch.value;
                this.lastSwitchValue = this.switchValue;
                return this.showNotFound();
            } 
        }

        if (this.ddSearch.value !== this.lastSearchValue || this.lastSwitchValue !== this.switchValue) {
            this.dropdownList.innerHTML = '';

            if (this.ddLisItems.length <= 1) {
                if (this.ddLisItems.length === 0) {
                    return this.showNotFound();
                }

                if (this.ddLisItems[0] === this.selected.textContent) {
                    return this.showNotFound();
                }
            }

            this.ddLisItems.forEach(item => {
                if (item === this.selected.textContent) return;

                const listItemElem = document.createElement('li');
                listItemElem.classList.add('form-dropdown', 'dropdown-item', 'fw-normal', 'input-dd-fs');
                listItemElem.textContent = item;
                this.dropdownList.appendChild(listItemElem);
            });

            this.dropdownList.classList.remove('visually-hidden');
        } else this.dropdownList.classList.remove('visually-hidden');

        this.lastSwitchValue = this.switchValue;
        this.lastSearchValue = this.ddSearch.value;
    };

    setInvalid(elem, elemLabel) {
        elemLabel.classList.add('text-danger', 'is-invalid');
        elem.classList.remove('border-dark');
        elem.classList.add('is-invalid', 'border-2', 'border-danger');
    };

    setValid(elem, elemLabel) {
        elemLabel.classList.remove('text-danger', 'is-invalid');
        elem.classList.add('border-dark');
        elem.classList.remove('is-invalid', 'border-2', 'border-danger');
    };

    isValidated(elem, label) {
        if (!elem.checkValidity()) {
            this.setInvalid(this.ddSearch, label);
        }else {
            this.setValid(this.ddSearch, label);
        }
    }

    setEventListeners() {
        this.ddToggle.addEventListener('click', () => this.handleDropdownInput());
        this.dropdownList.addEventListener('click', (e) => this.handleDropdownItemClick(e));
        this.resetBtn && this.resetBtn.addEventListener('click', () =>  this.reset());

        this.form && this.form.addEventListener("submit", () => this.isValidated(this.toSubmit, this.label));
    };

    reset() {
        const radioSwitch = document.querySelectorAll(`#${this.config.container} .idd-switch`);

        this.makeVisibleListItem();
        this.toSubmit.value = '';
        this.selected.textContent = '';
        this.selected.classList.add('d-none');
        this.resetBtn.classList.add('d-none');
        this.searchValue = '';
        this.switchValue = null;
        this.dropdownList.classList.add('visually-hidden');

        radioSwitch && radioSwitch.forEach(elem => elem.checked = false);
    };

    makeVisibleListItem() {
        const hiddenListItem = this.dropdownList.querySelector('.d-none');
        if (hiddenListItem) hiddenListItem.classList.remove('d-none');
    };

    showNotFound () {
        this.dropdownList.style.textAlign = 'center';
        this.dropdownList.textContent = 'Not found';
    };
}