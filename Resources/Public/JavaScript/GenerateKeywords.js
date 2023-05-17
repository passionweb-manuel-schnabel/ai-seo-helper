define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.getElementById('generateKeywords').addEventListener("click", function(ev) {
            ev.preventDefault();

            let pageId = parseInt(this.getAttribute('data-page-id'));
            let fieldName = this.getAttribute('data-field-name');

            sendAjaxRequest(pageId, fieldName);
        });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     */
    function sendAjaxRequest(pageId, fieldName) {
        Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.start'], TYPO3.lang['AiSeoHelper.notification.generation.start.keywords'], 8);
        new AjaxRequest(TYPO3.settings.ajaxUrls['keywords_generation'])
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
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.keywords'], 8);
                }
            })
            .catch((error) => {
                Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.error'], error);
            });
    }
});
