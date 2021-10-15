/**
 * Function to mark checkbox when filing quantity
 * @param inputElement
 * @param checkBoxToMark
 */
function markPackageElement(inputElement, checkBoxToMark) {
    $('.'+inputElement).on('input', function (index) {
        let elementId = $(this).data('element-id');
        if ($(this).val() > 0) {
            $('#'+ checkBoxToMark + elementId).prop('checked', true);
        } else {
            $('#'+ checkBoxToMark + elementId).prop('checked', false);
        }
    });
}
