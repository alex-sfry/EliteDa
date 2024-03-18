export const tradeRouteForm = (isValidated, loader, removeLoader) => {
    const form = document.querySelector('#tr-form');
    const handleSubmit = (e) => {
        const cargoSpaceLabel = document.querySelector('label[for=\'cargo\']');
        const cargoSpace = document.querySelector('#cargo');
        const profitLabel = document.querySelector('label[for=\'profit\']');
        const profit = document.querySelector('#profit');

        if (!form.checkValidity()) {
            e.preventDefault();
        }

        isValidated(cargoSpace, cargoSpaceLabel);
        isValidated(profit, profitLabel);
    };

    form.addEventListener('submit', (e) => handleSubmit(e));

    // const observer = new MutationObserver(handleSelectedSysChange);
    // observer.observe(selectedSys, {childList: true});
};