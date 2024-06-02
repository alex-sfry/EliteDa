export const isValidated = (elem, elemLabel) => {
    if (!elem.checkValidity()) {
        setInvalid(elem, elemLabel);
    } else {
        setValid(elem, elemLabel);
    }
};

const setInvalid = (elem, elemLabel) => {
    if ($(elem).attr('pattern') === "[0-9]+") {
        if (elem.validationMessage === 'Please match the requested format.') {
            $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Only numeric values are allowed');
        } else {
            $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Field must not be empty');
        }
    }
    
    $(elemLabel).addClass('text-danger is-invalid');
    $(elem).removeClass('border-dark');
    $(elem).addClass('is-invalid border-2 border-danger');
};

const setValid = (elem, elemLabel) => {
    $(elemLabel).removeClass('text-danger is-invalid');
    $(elem).addClass('border-dark');
    $(elem).removeClass('is-invalid border-2 border-danger');
};

