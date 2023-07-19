define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.querySelectorAll('.ai-seo-helper-news-suggestions-generation-btn').forEach(function(button) {
            button.addEventListener("click", function(ev) {
                ev.preventDefault();

                let newsId = parseInt(this.getAttribute('data-news-id'));
                let folderId = parseInt(this.getAttribute('data-folder-id'));
                let fieldName = this.getAttribute('data-field-name');

                sendAjaxRequest(newsId, folderId, fieldName);
            });
        });
    }

    /**
     *
     * @param {int} newsId
     * @param {int} folderId
     * @param {string} fieldName
     */
    function sendAjaxRequest(newsId, folderId, fieldName) {
        Notification.info(TYPO3.lang['AiSeoHelper.notification.generation.start'], TYPO3.lang['AiSeoHelper.notification.generation.start.suggestions'], 8);
        new AjaxRequest(TYPO3.settings.ajaxUrls['news_'+fieldName+'_generation'])
            .post(
                { newsId: newsId, folder: folderId }
            )
            .then(async function (response) {
                const resolved = await response.resolve();
                const responseBody = JSON.parse(resolved);
                if(responseBody.error) {
                    Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.requestError'], responseBody.error);
                } else {
                    handleResponse(newsId, fieldName, responseBody)
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.suggestions'], 8);
                }
            })
            .catch((error) => {
                Notification.error(TYPO3.lang['AiSeoHelper.notification.generation.error'], error);
            });
    }

    /**
     *
     * @param {int} newsId
     * @param {string} fieldName
     * @param {object} responseBody
     */
    function handleResponse(newsId, fieldName, responseBody) {

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
                    if(document.querySelector('input[data-formengine-input-name="data[tx_news_domain_model_news]['+newsId+']['+fieldName+']"]')) {
                        document.querySelector('input[data-formengine-input-name="data[tx_news_domain_model_news]['+newsId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        document.querySelector('input[name="data[tx_news_domain_model_news]['+newsId+']['+fieldName+']"]').value = selectedSuggestion.value;
                    } else {
                        document.querySelector('textarea[data-formengine-input-name="data[tx_news_domain_model_news]['+newsId+']['+fieldName+']"]').value = selectedSuggestion.value;
                        document.querySelector('textarea[name="data[tx_news_domain_model_news]['+newsId+']['+fieldName+']"]').value = selectedSuggestion.value;
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
});
