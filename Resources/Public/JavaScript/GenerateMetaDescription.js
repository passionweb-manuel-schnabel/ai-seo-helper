define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.getElementById('generateMetaDescription').addEventListener("click", function(ev) {
            ev.preventDefault();

            let pageId = ev.target.getAttribute('data-page-id');
            let fieldName = ev.target.getAttribute('data-field-name');

            sendAjaxRequest(pageId, fieldName);
        });
    }

     /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     */
    function sendAjaxRequest(pageId, fieldName) {
         Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.start'], TYPO3.lang['AiSeoHelper.notification.generation.start.metaDescription'], 5);
         new AjaxRequest(TYPO3.settings.ajaxUrls['generate-meta-description'])
             .post(
                 { pageId: pageId }
             )
             .then(async function (response) {
                 const resolved = await response.resolve();
                 const responseBody = JSON.parse(resolved);
                 if(responseBody.error) {
                     Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.requestError'], responseBody.error);
                 } else {
                     document.querySelector('textarea[name="data[pages]['+pageId+']['+fieldName+']"]').value = responseBody.output;
                     Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.metaDescription'], 5);
                 }
             })
             .catch((error) => {
                 Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.error'], error);
             });
    }
});
