import AjaxRequest from "@typo3/core/ajax/ajax-request.js";
import Notification from "@typo3/backend/notification.js";

class GenerateKeywords {
    constructor() {
        this.addEventListener = this.addEventListener.bind(this);
        this.addEventListener();
    }

    addEventListener() {
        let executeRequest = this.sendAjaxRequest;
        document.getElementById('generateKeywords').addEventListener("click", function(ev) {
            ev.preventDefault();

            let pageId = ev.target.getAttribute('data-page-id');
            let fieldName = ev.target.getAttribute('data-field-name');

            executeRequest(pageId, fieldName);
        });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     */
    sendAjaxRequest(pageId, fieldName) {
        Notification.info('Start generation', 'Keywords generation is in progress. Please wait.', 5);
        new AjaxRequest(TYPO3.settings.ajaxUrls['generate-keywords'])
            .post(
                { pageId: pageId }
            )
            .then(async function (response) {
                const resolved = await response.resolve();
                const data = JSON.parse(resolved);
                document.querySelector('textarea[name="data[pages]['+pageId+']['+fieldName+']"]').value = data.output;
                Notification.success('Start generation', 'Keywords were generated successfully!', 10);
            })
            .catch((error) => {
                Notification.error('Error', error);
            });
    }
}

export default new GenerateKeywords();
