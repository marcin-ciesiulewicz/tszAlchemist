/**
 * This file loads Packages forms based on route view
 */

function loadPackageOnSelect(){
    $('#package').on('select2:select', function (e) {

        //the container into which we are loadeing the ajax response with the Package view
        let packagesContainer = $('.packages-container');

        packagesContainer.html('');

        let packageId = $(this).find(':selected').val(),
            urlCreate = route('packages.create');

        //loading a form to create a new Package
        if (packageId == 'new_package') {

            ajaxLoadView(urlCreate, null ,packagesContainer)

            //add a custom package nem on the campaigns.create view
            if (route().current('campaigns.create')){
                let companyName = $('#company_id').find(':selected').text().toLowerCase().replace(/ /g, '_'),
                    currentDate = (new Date()).toISOString().split('T')[0].replace(/-/g, '_');
                $('#package_name').val(companyName+'_custom_'+currentDate);
            }

            //load Package edit or show form, depending on the current view
        } else if (packageId != '') {

            if(route().current('packages.index')){

                let urlEdit = route('packages.edit', packageId);
                ajaxLoadView(urlEdit, null ,packagesContainer);

            }else{
                let urlShow = route('packages.show', packageId);
                ajaxLoadView(urlShow, null ,packagesContainer);

            }


        }

    });
}
