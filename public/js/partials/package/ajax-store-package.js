/**
 *Function to store/update packages.
 * @param method - type of ajax method to use, required parameter
 * @param url - controller route, required parameter
 * @param data  - data object to send, required parameter
 * @param elementToAppend - element selector to append the notification to
 */
function ajaxStorePackage(method, url, data, elementToAppend) {
    $.ajax({
        method: method,
        url: url,
        data: data,
        dataType: "json",
        async: true
    })
        .fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
            ajaxResponseFail(jqXHR.responseJSON, elementToAppend)
        })
        .done(function (resp) {

            if (resp.status == 'success') {

                elementToAppend.html('').append(alertNotification('success', `Package stored successfully. Page will reload now!`)).hide().fadeIn('slow');

                $('#add-package-form fieldset').attr('disabled', 'disabled');

                //this part is used in campaigns.create and campaigns.edit views to save package while saving or editing campaigns
                let packageId = $('#package_id');

                if (packageId.length){
                    packageId.val(resp.packageId)
                    $('#edit_campaign_form').submit();
                    $('#create_campaign_form').submit();
                }else{
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }

            } else if (resp.status == 'error') {

                elementToAppend.html('');

                elementToAppend.append(alertNotification('danger', `Error occurred. Please check the log file`)).hide().fadeIn('slow');
            }

        });
}
