export const isValidated = (elem, elemLabel) => {
    if (!elem.checkValidity()) {
        setInvalid(elem, elemLabel);
    } else {
        setValid(elem, elemLabel);
    }
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

