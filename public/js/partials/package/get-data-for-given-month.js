/**
 *Function to gather appropriate data for a selected month of the package
 * @param monthToGetDataFrom - jQuery selector of the first month checkbox input, required parameter
 * @param inputToValidate - string, id name of amount input that should be validated, required parameter
 * @param frequencyElement - string, id name of the second month select frequency field, optional (only for the second month elements )
 * @returns {{amountToValidate: boolean, packageElementsObject: {}}}
 */
function getDataForGivenMonth(monthToGetDataFrom, inputToValidate, frequencyElement) {

    let amountToValidate = true,
        packageElementsObject = {},
        fieldTypeBinary = 2;

    monthToGetDataFrom.each(function (index) {

        if ($(this).prop('checked')) {

            let elementId = $(this).data('element-id'),
                elementName = $(this).data('element-name'),
                elementAmount = 0,
                elementToValidate = $('#'+ inputToValidate + elementId);

            if ($(this).data('element-field-type') === fieldTypeBinary) {
                elementAmount = 1;
            } else {

                if (elementToValidate.val() === '' || elementToValidate.val() <= 0) {
                    elementToValidate.addClass('is-invalid');
                    elementToValidate.focus();
                    amountToValidate = false;
                    return false;
                } else {
                    elementAmount = parseInt(elementToValidate.val());
                    elementToValidate.removeClass('is-invalid');
                    amountToValidate = true;
                }

            }

            if (frequencyElement !== null) {
                let packageFrequency = $('#' + frequencyElement + elementId).find(':selected').val();

                packageElementsObject[index] = {
                    elementId: elementId,
                    elementName: elementName,
                    elementAmount: elementAmount,
                    packageFrequency: packageFrequency
                };

            }else {
                packageElementsObject[index] = {
                    elementId: elementId,
                    elementName: elementName,
                    elementAmount: elementAmount
                };
            }

        }

    });

    return {
        amountToValidate,
        packageElementsObject
    }
}
