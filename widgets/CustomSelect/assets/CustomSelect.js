class CustomSelect {
    constructor(config) {
        if (!config) return console.log('provide config for CustomSelect');
        this.config = config;

        this.selectedItemsDiv = document.querySelector(`#${config.container} .selected-items`);
        this.itemsToSubmitSelect = document.querySelector(`#${config.toSubmit}`);
        this.form = this.itemsToSubmitSelect.closest('form');
        this.label = document.querySelector(`#${config.container} label[for=${config.toSubmit}]`);

        this.initDropdownValues();
        this.setEventListeners();
        this.setSelectedItemsDivMsg();
    }

    initDropdownValues = () => {
        const selectedItems = this.selectedItemsDiv.querySelectorAll('div');

        selectedItems.forEach(selectedItem => {
            const dropdownItemsToHide = [...this.getDropdownListItems()]
                .find(item => item.textContent.trim() === selectedItem.textContent.trim());
            dropdownItemsToHide.classList.add('d-none');
        });
    };

    handleDropdownInput = (e) => {
        this.getDropdownListItems().forEach(item => {
            !item.textContent.toLowerCase().trim().startsWith(e.target.value.toLowerCase().trim()) ?
                item.classList.add('hidden') :
                item.classList.remove('hidden');
        });
    };

    handleDropdownItemClick = (e) => {
        if (!e.target.classList.contains('c-list-item')) return;

        if (this.itemsToSubmitSelect.querySelectorAll('option').length === 5) return;

        const selectedItemDivider = `
            <span class="border-start border-1 border-black"></span>
            <button class="close border-0 rounded-2 m-0 p-0" type="button" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="svg-close bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
        `;

        const hiddenOption = document.querySelector(`#${this.config.toSubmit} option`) ?
            document.querySelector(`#${this.config.toSubmit} option[value="${e.target.textContent.trim()}"]`) :
            null;

        const selItm = document.createElement('div');
        selItm.classList.add('ps-1', 'rounded-2');
        selItm.innerHTML = e.target.textContent + selectedItemDivider;

        if (this.selectedItemsDiv.textContent === 'selected commodities') this.selectedItemsDiv.textContent = '';
        this.selectedItemsDiv.appendChild(selItm);

        const clickedItem =
            [...this.getDropdownListItems()].find(item => item.textContent.trim() === e.target.textContent.trim());
        clickedItem && clickedItem.classList.add('d-none');

        if (!hiddenOption) {
            const optionItem = document.createElement('option');
            optionItem.setAttribute('value', e.target.textContent.trim());
            optionItem.setAttribute('selected', '');
            this.itemsToSubmitSelect.appendChild(optionItem);
        }
    };

    handleDeleteSelectedItem = (e) => {
        if (e.target.matches('button > .svg-close') || e.target.matches('button > .svg-close > path')) {
            const selItmDiv = e.target.closest(`#${this.config.container} .c-select .selected-items > div`);
            selItmDiv.remove();

            const optionToDelete = this.itemsToSubmitSelect.querySelector(
                `option[value="${selItmDiv.textContent.trim()}"]`,
            );

            const deletedItem = [...this.getDropdownListItems()].find(item => {
                return item.textContent.trim() === selItmDiv.textContent.trim();
            });

            deletedItem.classList.remove('d-none');
            optionToDelete.remove();
        }

        this.setSelectedItemsDivMsg();
    };

    setInvalid = (elemHidden, elemVisible, elemLabel) => {
        elemLabel.classList.add('text-danger');
        elemHidden.classList.add('is-invalid');
        elemVisible.classList.add('border-2', 'border-danger');
        elemVisible.classList.remove('border-dark');
    };

    setValid = (elemHidden, elemVisible, elemLabel) => {
        elemLabel.classList.remove('text-danger');
        elemHidden.classList.remove('is-invalid');
        elemVisible.classList.remove('border-2', 'border-danger');
        elemVisible.classList.add('border-dark');
    };

    isValidated = (elem, label) => {
        if (!elem.checkValidity()) {
            this.setInvalid(this.itemsToSubmitSelect, this.selectedItemsDiv, label);
        }else {
            this.setValid(this.itemsToSubmitSelect, this.selectedItemsDiv, label);
        }
    }

    setEventListeners = () => {
        const commoditiesSearchField = document.querySelector(`#${this.config.search}`);
        const dropdownList = document.querySelector(`#${this.config.container} .c-list`);
        commoditiesSearchField.addEventListener('input', (e) => this.handleDropdownInput(e));
        this.selectedItemsDiv.addEventListener('click', (e) => this.handleDeleteSelectedItem(e));
        dropdownList.addEventListener('click', (e) => this.handleDropdownItemClick(e));

        this.form.addEventListener("submit", () => this.isValidated(this.itemsToSubmitSelect, this.label));
    };

    getDropdownListItems = () => {
        return document.querySelectorAll(`#${this.config.search} + ul > .dropdown-item`);
    };

    setSelectedItemsDivMsg = () => {
        const selectedItems = this.selectedItemsDiv.querySelectorAll('div');

        if (selectedItems.length === 0) {
            this.selectedItemsDiv.textContent = this.config.placeholder;
        }
    };
}
