var md = window.markdownit('commonmark');
function loadMarkdown() {
    jQuery.support.cors = true;
    $.ajax({
        url: link,
        type: 'GET',
        crossDomain: true,
        success: function (data) {
            $('#wiki').append(md.render(data));
        },
        error: function (err) {
            console.log(err);
        }
    });
}

//hack to fix pathname according to wiki for main help page
if (window.location.pathname === '/help') {
    if (history.replaceState) {
        history.replaceState({}, null, '/help/');
    } else {
        window.location.pathname = '/help/'
    }
}
$(function () {
    loadMarkdown();
});
