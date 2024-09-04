export const validate = (elem) => {
    if ($(elem).attr('pattern') === "[0-9]+") {
        if (elem.validationMessage === 'Please match the requested format.') {
            $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Only numeric values are allowed');
        } else {
            $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Field must not be empty');
        }
    }
};


