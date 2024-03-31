export const tradeRouteForm = (isValidated, loader, removeLoader, fetchData) => {
    const form = $('#tr-form');

    const handleSubmit = (e) => {
        const cargoSpaceLabel = $('label[for=\'cargo\']').get(0);
        const cargoSpace = $('#cargo').get(0);
        const profitLabel = $('label[for=\'profit\']').get(0);
        const profit = $('#profit').get(0);

        if (!form.get(0).checkValidity()) e.preventDefault();

        isValidated(cargoSpace, cargoSpaceLabel);
        isValidated(profit, profitLabel);
    };

    form.on('submit', (e) => handleSubmit(e));

    // const observer = new MutationObserver(handleSelectedSysChange);
    // observer.observe(selectedSys, {childList: true});
};
