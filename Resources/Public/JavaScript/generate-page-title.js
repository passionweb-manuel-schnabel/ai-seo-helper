import AjaxRequest from "@typo3/core/ajax/ajax-request.js";
import Notification from "@typo3/backend/notification.js";

class GeneratePageTitle {
    constructor() {
        this.addEventListener = this.addEventListener.bind(this);
        this.addEventListener();
    }
    addEventListener() {
        let executeRequest = this.sendAjaxRequest;
        let handleResponse = this.handlePageTitleResponse;
        document.getElementById('generatePageTitle').addEventListener("click", function(ev) {
            ev.preventDefault();

            let pageId = ev.target.getAttribute('data-page-id');
            let fieldName = ev.target.getAttribute('data-field-name');

            executeRequest(pageId, fieldName, handleResponse);
        });
    }


    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     * @param {function} handleResponse
     */
    sendAjaxRequest(pageId, fieldName, handleResponse) {
        Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.start'], TYPO3.lang['AiSeoHelper.notification.generation.start.pageTitleSuggestions'], 5);
        new AjaxRequest(TYPO3.settings.ajaxUrls['generate-page-title'])
            .post(
                { pageId: pageId }
            )
            .then(async function (response) {
                const resolved = await response.resolve();
                const responseBody = JSON.parse(resolved);
                if(responseBody.error) {
                    Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.requestError'], responseBody.error);
                } else {
                    handleResponse(pageId, fieldName, responseBody.output)
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.pageTitleSuggestions'], 5);
                }
            })
            .catch((error) => {
                Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.error'], error);
            });
    }

    /**
     *
     * @param pageId
     * @param fieldName
     * @param content
     */
    handlePageTitleResponse(pageId, fieldName, content) {
        let pageTitleSelection = document.querySelector('.ai-seo-helper-suggested-page-titles');
        if(pageTitleSelection) {
            document.querySelector('.ai-seo-helper-suggested-page-titles').remove();
        }

        pageTitleSelection = document.createElement('div');
        pageTitleSelection.innerHTML = content;
        pageTitleSelection.classList.add('ai-seo-helper-suggested-page-titles');
        document.getElementById('generatePageTitle').closest('.formengine-field-item').append(pageTitleSelection);
        document.getElementById('setPageTitleBtn').addEventListener('click', function(ev) {
            ev.preventDefault();
            let selectedPageTitle = document.querySelector('input[name="page_title"]:checked');
            if(selectedPageTitle === null) {
                Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.pageTitleSuggestions.missingSelection'], TYPO3.lang['AiSeoHelper.notification.generation.pageTitleSuggestions.missingSelectionInfo'], 5);
            } else {
                document.querySelector('input[data-formengine-input-name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedPageTitle.value;
                document.querySelector('input[name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedPageTitle.value;
                pageTitleSelection.remove();
            }
        });
        document.getElementById('dropPageTitleBtn').addEventListener('click', function(ev) {
            ev.preventDefault();
            pageTitleSelection.remove();
        });
    }
}

export default new GeneratePageTitle();
