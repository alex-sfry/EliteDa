import { tSelectRingsSettings } from "./tSelectSettings.js";

export const initTSelect = (elem) => {
    // eslint-disable-next-line no-undef, no-unused-vars
    const tSelect = new TomSelect(elem, tSelectRingsSettings({
        searchField: 'system',
        valueField: 'system',
        labelField: 'system',
        plugins: ['dropdown_input'],
        endpoint: '/system/get/'
    }));

    // fix for TomSelect label bug (id, for)
    $('.tselect-lbl-1').attr('for', 'refSystem');
    $('.tselect-lbl-1').removeAttr('id');
};