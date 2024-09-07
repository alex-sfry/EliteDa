import { tSelectRingsSettings } from "./tSelectSettings.js";

export const ringsForm = (loader, removeLoader) => {
    // eslint-disable-next-line no-undef, no-unused-vars
    const tSelect = new TomSelect("#refSystem", tSelectRingsSettings);
    const $form = $("#rings-form");
    const $table = $(".rings-table");
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
            $form.addClass("was-validated");
        } else loader($form, $table);
    };

    $form.on("submit", handleSubmit);
    // fix for TomSelect label bug (id, for)
    $('.tselect-lbl-1').attr('for', 'refSystem');
    $('.tselect-lbl-1').removeAttr('id');
};