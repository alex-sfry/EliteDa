import { tSelectAjaxSettings } from "./tSelectSettings.js";

export /**
 * Description placeholder
 *
 * @param {string} elem
 * @param {boolean} [ajax=true]
 * @param {string} endpoint
 */
const initTSelect = (elem, ajax = false, endpoint) => {
    if (ajax) {
        // eslint-disable-next-line no-undef, no-unused-vars
        const tSelect = new TomSelect(elem, tSelectAjaxSettings({
            searchField: 'system',
            valueField: 'system',
            labelField: 'system',
            plugins: ['dropdown_input'],
            endpoint: endpoint 
        }));
    } else if (elem === '#ships-cMainSelect') {
        // eslint-disable-next-line no-undef, no-unused-vars
        const tSelectNoAjax = new TomSelect(elem, {
            plugins: ['dropdown_input'],
            sortField: [{ field: '$order' }, { field: '$score' }],
            maxOptions: null,
        });
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
    $('.tselect-lbl-3').attr('for', 'ships-cMainSelect');
    $('.tselect-lbl-3').removeAttr('id');
};