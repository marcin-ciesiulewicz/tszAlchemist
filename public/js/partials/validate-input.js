/**
 * Function to validate if input isn't empty
 * @param selector - selector of input to validate
 * @returns {boolean}
 */
function validateInput(selector){

    let inputSelector = selector,
        isInputValid = true;

    if (inputSelector.val() === '') {
        inputSelector.addClass('is-invalid');
        isInputValid = false;
        inputSelector.focus();
    } else {
        inputSelector.removeClass('is-invalid');
        isInputValid = true;
    }

    return isInputValid;
}
