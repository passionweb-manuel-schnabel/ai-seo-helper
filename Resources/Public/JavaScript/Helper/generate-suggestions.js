import AjaxRequest from "@typo3/core/ajax/ajax-request.js";
import Notification from "@typo3/backend/notification.js";

class GenerateSuggestions {
    constructor() {
        this.addEventListener();
    }

    addEventListener() {
        let handleResponse = this.handleResponse;
        let executeRequest = this.sendAjaxRequest;
        let addSelectionToAdditionalFields = this.addSelectionToAdditionalFields;

        document.querySelectorAll('.ai-seo-helper-suggestions-generation-btn').forEach(function(button) {
            button.addEventListener("click", function(ev) {
                ev.preventDefault();

                let pageId = parseInt(this.getAttribute('data-page-id'));
                let fieldName = this.getAttribute('data-field-name');

                executeRequest(pageId, fieldName, handleResponse, addSelectionToAdditionalFields);
            });
        });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     * @param {function} handleResponse
     * @param {function} addSelectionToAdditionalFields
     */
    sendAjaxRequest(pageId, fieldName, handleResponse, addSelectionToAdditionalFields) {
        Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.start'], TYPO3.lang['AiSeoHelper.notification.generation.start.suggestions'], 8);
        new AjaxRequest(TYPO3.settings.ajaxUrls[fieldName+'_generation'])
            .post(
                { pageId: pageId }
            )
            .then(async function (response) {
                const resolved = await response.resolve();
                const responseBody = JSON.parse(resolved);
                if(responseBody.error) {
                    Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.requestError'], responseBody.error);
                } else {
                    handleResponse(pageId, fieldName, responseBody, addSelectionToAdditionalFields)
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.suggestions'], 8);
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
     * @param responseBody
     * @param addSelectionToAdditionalFields
     */
    handleResponse(pageId, fieldName, responseBody, addSelectionToAdditionalFields) {
        let selection = document.querySelector('.ai-seo-helper-suggestions');
        if(selection) {
            document.querySelector('.ai-seo-helper-suggestions').remove();
        }

        selection = document.createElement('div');
        selection.innerHTML = responseBody.output;
        selection.classList.add('ai-seo-helper-suggestions');
        document.getElementById(fieldName+'_generation').closest('.formengine-field-item').append(selection);
        if(document.getElementById('suggestionBtnSet')) {
            document.getElementById('suggestionBtnSet').addEventListener('click', function(ev) {
                ev.preventDefault();
                let selectedSuggestion = document.querySelector('input[name="generatedSuggestions"]:checked');
                if(selectedSuggestion === null) {
                    Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.suggestions.missingSelection'], TYPO3.lang['AiSeoHelper.notification.generation.suggestions.missingSelectionInfo'], 8);
                } else {
                    if(document.querySelector('input[data-formengine-input-name="data[pages]['+pageId+']['+fieldName+']"]')) {
                        document.querySelector('input[data-formengine-input-name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        document.querySelector('input[name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        addSelectionToAdditionalFields(responseBody.useForAdditionalFields, pageId, fieldName, selectedSuggestion.value);
                    } else {
                        document.querySelector('textarea[data-formengine-input-name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        document.querySelector('textarea[name="data[pages]['+pageId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        addSelectionToAdditionalFields(responseBody.useForAdditionalFields, pageId, fieldName, selectedSuggestion.value);
                    }
                    selection.remove();
                }
            });
        }
        if(document.getElementById('suggestionBtnRemove')) {
            document.getElementById('suggestionBtnRemove').addEventListener('click', function (ev) {
                ev.preventDefault();
                selection.remove();
            });
        }
    }

    addSelectionToAdditionalFields(useForAdditionalFields, pageId, fieldName, selectedSuggestionValue) {
        if(useForAdditionalFields && fieldName === 'seo_title') {
            Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.copy'], TYPO3.lang['AiSeoHelper.notification.generation.suggestions.ogTwitterTitlesUpdated'], 8);
            document.querySelector('input[data-formengine-input-name="data[pages]['+pageId+'][og_title]"]').value = selectedSuggestionValue;
            document.querySelector('input[name="data[pages]['+pageId+'][og_title]"]').value = selectedSuggestionValue;
            document.querySelector('input[data-formengine-input-name="data[pages]['+pageId+'][twitter_title]"]').value = selectedSuggestionValue;
            document.querySelector('input[name="data[pages]['+pageId+'][twitter_title]"]').value = selectedSuggestionValue;
        }
        if(useForAdditionalFields && fieldName === 'description') {
            Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.copy'], TYPO3.lang['AiSeoHelper.notification.generation.suggestions.ogTwitterDescriptionsUpdated'], 8);
            document.querySelector('textarea[data-formengine-input-name="data[pages]['+pageId+'][og_description]"]').value = selectedSuggestionValue;
            document.querySelector('textarea[name="data[pages]['+pageId+'][og_description]"]').value = selectedSuggestionValue;
            document.querySelector('textarea[data-formengine-input-name="data[pages]['+pageId+'][twitter_description]"]').value = selectedSuggestionValue;
            document.querySelector('textarea[name="data[pages]['+pageId+'][twitter_description]"]').value = selectedSuggestionValue;
        }
    }
}

export default new GenerateSuggestions();
