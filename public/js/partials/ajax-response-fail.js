/**
 *Function to handle ajax responses and notifications
 * @param responseJSON - jqXHR.responseJSON object should be passed
 * @param elementToAppend - element to append the response
 */
function ajaxResponseFail(responseJSON, elementToAppend){
    let message = '';
    if (typeof responseJSON != 'undefined') {
        message = responseJSON.message;
    }
    if (typeof responseJSON.errors != 'undefined'){
        message += ' ' + Object.values(responseJSON.errors);
    }
    elementToAppend.html('');
    elementToAppend.append(alertNotification('danger', message)).hide().fadeIn('slow');

}
