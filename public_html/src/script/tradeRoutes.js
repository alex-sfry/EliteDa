export const tradeRouteForm = (isValidated, loader, removeLoader) => {
    const $form = $('#tr-form');
    const $trRoute = $('.tr-route');
    removeLoader($trRoute);

    const handleSubmit = (e) => {
        const cargoSpaceLabel = $('label[for=\'cargo\']').get(0);
        const cargoSpace = $('#cargo').get(0);
        const profitLabel = $('label[for=\'profit\']').get(0);
        const profit = $('#profit').get(0);

        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
        } else loader($form, $trRoute);

        isValidated(cargoSpace, cargoSpaceLabel);
        isValidated(profit, profitLabel);
    };

    $('.btn-copy').on('click', function () {
        navigator.clipboard.writeText($(this).siblings('.table-link-tr').text());
        $(this).text('copied').addClass('btn-copy-active');
        $(".btn-copy:contains('copied')").not(this).text('copy').removeClass('btn-copy-active');
        
    });

    $form.on('submit', (e) => handleSubmit(e));
};
