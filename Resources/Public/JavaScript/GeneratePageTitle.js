define(["TYPO3/CMS/Core/Ajax/AjaxRequest", "TYPO3/CMS/Backend/Notification"], function(AjaxRequest, Notification) {

    addEventListener();
    function addEventListener() {
        document.getElementById('generatePageTitle').addEventListener("click", function(ev) {
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
                    handlePageTitleResponse(pageId, fieldName, responseBody.output)
                    Notification.success(TYPO3.lang['AiSeoHelper.notification.generation.finish'], TYPO3.lang['AiSeoHelper.notification.generation.finish.pageTitleSuggestions'], 5);
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
     * @param {string} content
     */
    function handlePageTitleResponse(pageId, fieldName, content) {
        let pageTitleSelection = document.querySelector('.ai-seo-helper-suggested-page-titles');
        if (pageTitleSelection) {
            document.querySelector('.ai-seo-helper-suggested-page-titles').remove();
        }

        pageTitleSelection = document.createElement('div');
        pageTitleSelection.innerHTML = content;
        pageTitleSelection.classList.add('ai-seo-helper-suggested-page-titles');
        document.getElementById('generatePageTitle').closest('.formengine-field-item').append(pageTitleSelection);
        if(document.getElementById('setPageTitleBtn')) {
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
        }
        if(document.getElementById('dropPageTitleBtn')) {
            document.getElementById('dropPageTitleBtn').addEventListener('click', function (ev) {
                ev.preventDefault();
                pageTitleSelection.remove();
            });
        }
    }
});
