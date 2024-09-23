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

    $('#targetSysStation').attr('value') === '' && $('#targetSysStation').removeAttr('value');

    const endpoints = {
        system: '/system/get/',
        station: '/system-station/'
    };
    // eslint-disable-next-line no-undef, no-unused-vars
    const tSelect = new TomSelect('#targetSysStation', {
        searchField: 'system',
        valueField: 'system',
        labelField: 'system',
        plugins: ['dropdown_input'],
        sortField: [{ field: '$order' }, { field: '$score' }],
        options: [{'system': $('#targetSysStation').attr('value')}],
        loadThrottle: 500,
        hideSelected: true,
        highlight: false,
        shouldLoad: query => query.length < 2 ? false : true,
        load: async function (query, callback) {
            this.clearOptions();
            const endpoint = endpoints[$('.idd-switch').filter(':checked').attr('value')];
            try {
                const response = await fetch(`${endpoint}${query}/`);

                if (response.ok) {
                    const data = await response.json();

                    if (endpoint === '/system-station/') {
                        data.forEach(item => {
                            item.system = `${item.system} / ${item.station}`;
                        });
                    }

                    callback(data);
                } else {
                    console.log('fetch error');
                }
            }
            catch (error) {
                console.log(error.message);
                callback();
            }
        }
    });

    $('.btn-copy').on('click', function () {
        navigator.clipboard.writeText($(this).siblings('.table-link-tr').text());
        $(this).text('copied').addClass('btn-copy-active');
        $(".btn-copy:contains('copied')").not(this).text('copy').removeClass('btn-copy-active');

    });

    $form.on('submit', (e) => handleSubmit(e));
};
