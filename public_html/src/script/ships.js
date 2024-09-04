export const shipsForm = (loader, removeLoader) => {
    const $form = $('#ships-form');
    const $table = $('.ships-table');
    // const shipSelectLabel = $('label[for=\'c-hiddenSelect\']').get(0);
    // const shipSelect = $('#c-hiddenSelect').get(0);
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            $form.addClass('was-validated');
            e.preventDefault();
        } else loader($form, $table);
    };

    $form.on('submit', handleSubmit);
};
