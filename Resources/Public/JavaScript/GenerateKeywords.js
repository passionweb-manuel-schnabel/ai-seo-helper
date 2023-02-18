define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.getElementById('generateKeywords').addEventListener("click", function(ev) {
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
        Notification.info('Start generation', 'Keywords generation is in progress. Please wait.', 5);
        new AjaxRequest(TYPO3.settings.ajaxUrls['generate-keywords'])
            .post(
                { pageId: pageId }
            )
            .then(async function (response) {
                const resolved = await response.resolve();
                const responseBody = JSON.parse(resolved);
                if(responseBody.error) {
                    Notification.error('Error', responseBody.error);
                } else {
                    document.querySelector('textarea[name="data[pages]['+pageId+']['+fieldName+']"]').value = responseBody.output;
                    Notification.success('Start generation', 'Keywords were generated successfully!', 10);
                }
            })
            .catch((error) => {
                Notification.error('Unexpected error', error);
            });
    }
});