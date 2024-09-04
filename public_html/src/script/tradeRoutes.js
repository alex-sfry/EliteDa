export const tradeRouteForm = (validate, loader, removeLoader) => {
    const $form = $('#tr-form');
    const $trRoute = $('.tr-route');
    removeLoader($trRoute);

    const handleSubmit = (e) => {
        const cargoSpace = $('#cargo').get(0);
        const profit = $('#profit').get(0);

        if (!$form.get(0).checkValidity()) {
            $('#tr-form').addClass('was-validated');
            e.preventDefault();
        } else loader($form, $trRoute);

        validate(cargoSpace);
        validate(profit);
    };

    $('.btn-copy').on('click', function () {
        navigator.clipboard.writeText($(this).siblings('.table-link-tr').text());
        $(this).text('copied').addClass('btn-copy-active');
        $(".btn-copy:contains('copied')").not(this).text('copy').removeClass('btn-copy-active');
        
    });

    $form.on('submit', (e) => handleSubmit(e));
};
