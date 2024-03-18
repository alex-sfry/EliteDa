export const isValidated = (elem, elemLabel) => {
    if (!elem.checkValidity()) {
        setInvalid(elem, elemLabel);

        // if (elem.parentElement.classList.contains('c-select')) {
        //     const selectedItemsDiv = elem.parentElement.querySelector('.c-select .selected-items');
        //     setInvalidCustomElems(selectedItemsDiv);
        // }
        //
        // if (elem.closest('.c-dropdown')) {
        //     const visibleInput = document.querySelector('.sys-search');
        //     setInvalidCustomElems(visibleInput);
        // }
    } else {
        setValid(elem, elemLabel);

        // if (elem.parentElement.classList.contains('c-select')) {
        //     const selectedItemsDiv = elem.parentElement.querySelector('.c-select .selected-items');
        //     setValidCustomElems(selectedItemsDiv);
        // }
        //
        // if (elem.closest('.c-dropdown')) {
        //     const visibleInput = document.querySelector('.sys-search');
        //     setValidCustomElems(visibleInput);
        // }
    }

    // if ()
};

const setInvalid = (elem, elemLabel) => {
    elemLabel.classList.add('text-danger', 'is-invalid');
    elem.classList.remove('border-dark');
    elem.classList.add('is-invalid', 'border-2', 'border-danger');
};

const setValid = (elem, elemLabel) => {
    elemLabel.classList.remove('text-danger', 'is-invalid');
    elem.classList.add('border-dark');
    elem.classList.remove('is-invalid', 'border-2', 'border-danger');
};

// const setInvalidCustomElems = (elem) => {
//     elem.classList.remove( 'border-dark');
//     elem.classList.add('border-2', 'border-danger');
// };
//
// const setValidCustomElems = (elem) => {
//     elem.classList.remove('border-2', 'border-danger');
//     elem.classList.add( 'border-dark');
// };
