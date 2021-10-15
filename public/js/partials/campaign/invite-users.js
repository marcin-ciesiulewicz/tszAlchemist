/**
 * add/remove users to invite
 */
function showHideRemoveUserBtn(){
    if($('.user-to-invite-details').length == 1){
        $('#remove_user_to_invite').hide();
    }else{
        $('#remove_user_to_invite').show();
    }
}
showHideRemoveUserBtn();

$('#add_user_to_invite').on('click', function (e){
    e.preventDefault();

    $('.users-to-invite').append(
        `
            <div class="row user-to-invite-details">
                <div class="form-group col-md-4">
                <span class="span-icon">
                    <i class="fas fa-user-edit" aria-hidden="true"></i>
                </span>
                    <input class="form-control form-control-sm input-padding first_name" type="text"
                           name="first_name[]" placeholder="First Name" required>
                </div>

                <div class="form-group col-md-4">
                <span class="span-icon">
                    <i class="fas fa-user-tag" aria-hidden="true"></i>
                </span>
                    <input class="form-control form-control-sm input-padding last_name" type="text"
                           name="last_name[]" placeholder="Last Name" required>
                </div>

                <div class="form-group col-md-4">
                <span class="span-icon">
                    <i class="fas fa-envelope-open-text" aria-hidden="true"></i>
                </span>
                    <input class="form-control form-control-sm input-padding email" type="email"
                           name="email[]" placeholder="Email" required>
                </div>
            </div>
          `
    );

    showHideRemoveUserBtn();

});

$('#remove_user_to_invite').on('click', function (e){
    e.preventDefault();

    $('.user-to-invite-details').last().detach();

    showHideRemoveUserBtn();

});
