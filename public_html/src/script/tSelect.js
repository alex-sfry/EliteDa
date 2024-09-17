import { tSelectAjaxSettings } from "./tSelectSettings.js";

/**
 * @param {string} elem 
 */
export const initTSelect = (elem, ajax = true) => {
    if (ajax) {
        // eslint-disable-next-line no-undef, no-unused-vars
        const tSelect = new TomSelect(elem, tSelectAjaxSettings({
            searchField: 'system',
            valueField: 'system',
            labelField: 'system',
            plugins: ['dropdown_input'],
            endpoint: '/system/get/'
        }));
    } else {
        // eslint-disable-next-line no-undef, no-unused-vars
        const tSelectNoAjax = new TomSelect(elem, {
            plugins: ['dropdown_input', 'remove_button'],
            sortField: [{ field: '$order' }, { field: '$score' }],
            maxOptions: null,
            maxItems: 5,
        });
    }

    // fix for TomSelect label bug (id, for)
    $('.tselect-lbl-1').attr('for', 'refSystem');
    $('.tselect-lbl-1').removeAttr('id');
    $('.tselect-lbl-2').attr('for', 'cMainSelect');
    $('.tselect-lbl-2').removeAttr('id');
};