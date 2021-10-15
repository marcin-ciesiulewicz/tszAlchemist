/**
 * loading package on document.read, on campaigns.show and campaigns.edit views
 */
function loadPackageOnReady(){
    $(document).ready(function () {

        //the container into which we are loadeing the ajax response with the Package view
        let packagesContainer = $('.packages-container');

        //---load package to the container
        let packageId = $('#package_id').val(),
            url = route('packages.show', packageId);

        if (packageId != '') {

            ajaxLoadView(url, null, packagesContainer);

        } else {
            packagesContainer.html('').append('<p>No Package assigned to this campaign</p>');
        }

    });
}
