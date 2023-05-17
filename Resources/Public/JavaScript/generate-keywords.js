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

            let pageId = parseInt(this.getAttribute('data-page-id'));
            let fieldName = this.getAttribute('data-field-name');

            executeRequest(pageId, fieldName);
        });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     */
    sendAjaxRequest(pageId, fieldName) {
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
}

export default new GenerateKeywords();
