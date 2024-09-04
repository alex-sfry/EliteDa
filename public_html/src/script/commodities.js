export const commoditiesForm = (loader, removeLoader) => {
    const $form = $('#c-form');
    const $table = $('.c-table');
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            $form.addClass('was-validated');
            e.preventDefault();
        } else loader($form, $table);
    };

    $form.on('submit', handleSubmit);
};
