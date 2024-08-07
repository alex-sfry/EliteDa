async function pasteFromClipboard() {
    const cbText = await navigator.clipboard.readText();
    const cbArr = cbText.split('\t');
    cbArr[cbArr.length - 1] = cbArr[cbArr.length - 1] === '\r\n' ? '' : cbArr[cbArr.length - 1];

    $('.form-control').each(function(index) {
        $(this).val(cbArr[index]);
    });
}

$("button[type='submit']").after('<button id="btnPaste" class="btn btn-light ms-3">Paste</button>');

$('#btnPaste').on('click', async function() {
    await pasteFromClipboard();
});

