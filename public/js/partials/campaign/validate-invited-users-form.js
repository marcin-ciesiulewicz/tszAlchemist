/**
 * function to validate user invitation form
 * @returns {boolean}
 */
function validateInvitedUsersForm(){
    if($('#create_teamwork_project').is(':checked')){

        //validate user invitations
        let isLastNameValid = true,
            isEmailValid = true;

        $('.first_name').each(function (i, item){

            if($(this).val() != ''){


                $('.last_name').each(function (k){

                    if($(this).val() == '' && i == k ){

                        $(this).focus().addClass('is-invalid');
                        isLastNameValid =false;
                    }else if($(this).val() != '' && i == k){
                        $(this).removeClass('is-invalid');
                    }
                });

                $('.email').each(function (z){
                    if($(this).val() == '' && i == z){

                        $(this).focus().addClass('is-invalid');
                        isEmailValid = false;
                    }else if($(this).val() != '' && i == z){
                        $(this).removeClass('is-invalid');
                    }
                });

            }
        });

        if(isLastNameValid != true || isEmailValid != true){
            return false;
        }else{
            $('.last_name').removeClass('is-invalid');
            $('.email').removeClass('is-invalid');
        }

    }
}
