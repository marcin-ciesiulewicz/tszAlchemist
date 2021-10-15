/**
 *Function to load a view with ajax
 * @param url
 * @param data
 * @param elementToAppendTo
 */
function ajaxLoadView(url, data, elementToAppendTo){
    $.ajax({
        method: "GET",
        url: url,
        data: data,
        type: 'html',
        async: false
    })
        .fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
            ajaxResponseFail(jqXHR.responseJSON, elementToAppendTo)
        })
        .done(function (resp) {
            elementToAppendTo.html('').append(resp).hide().fadeIn('slow');
        });
}
