/**
 * Function to add bootstrap alert notification
 * @param alertType - danger|warning etc.
 * @param message
 * @returns {string}
 */
function alertNotification(alertType, message) {
    return `<div class="alert alert-` + alertType + ` text-center" role="alert">
                 ` + message + `
           </div>`;
}
