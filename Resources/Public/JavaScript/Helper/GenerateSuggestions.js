define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.querySelectorAll('.ai-seo-helper-suggestions-generation-btn').forEach(function(button) {
            button.addEventListener("click", function(ev) {
                ev.preventDefault();

                let pageId = parseInt(this.getAttribute('data-page-id'));
                let fieldName = this.getAttribute('data-field-name');

                sendAjaxRequest(pageId, fieldName);
            });
        });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     */
    function sendAjaxRequest(pageId, fieldName) {
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
                    handleResponse(pageId, fieldName, responseBody)
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.suggestions'], 8);
                }
            })
            .catch((error) => {
                Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.error'], error);
            });
    }

    /**
     *
     * @param {int} pageId
     * @param {string} fieldName
     * @param {object} responseBody
     */
    function handleResponse(pageId, fieldName, responseBody) {

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

    /**
     *
     * @param {boolean} useForAdditionalFields
     * @param {int} pageId
     * @param {string} fieldName
     * @param {string} selectedSuggestionValue
     */
    function addSelectionToAdditionalFields(useForAdditionalFields, pageId, fieldName, selectedSuggestionValue) {
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
});
