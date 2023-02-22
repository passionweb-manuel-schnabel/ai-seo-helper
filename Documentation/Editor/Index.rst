.. include:: ../Includes.txt


Editors Manual
=====================

Target group: **Editors**

Generate meta description
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Added an additional button next to the meta description text field. When you click this button, the (text) content of the selected page is generated and a meta description that is as suitable as possible is created with the help of the AI. Currently, the page must not be deactivated in the backend. Depending on the page size, the process may take a few seconds. However, notifications are used to display appropriate information.

.. figure:: generate-meta-description.png

It can happen that the AI returns texts that exceed the maximum allowed length of the meta description. To additionally check the length of the meta description, the extension `Yoast SEO for TYPO3 <https://extensions.typo3.org/extension/yoast_seo>`_ can be used, for example, or various online tools.

Generate keywords
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Added an additional button next to the keywords text field. When you click this button, the (text) content of the selected page is generated and keywords that is as suitable as possible is created with the help of the AI. Currently, the page must not be deactivated in the backend. Depending on the page size, the process may take a few seconds. However, notifications are used to display appropriate information.

.. figure:: generate-keywords.png

Generate page title (suggestions)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Added an additional button next to the seo title text field. When you click this button, the (text) content of the selected page is generated and you get page title suggestions with the help of the AI. By default, the extension prepares the page title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option "showRawPageTitleSuggestions" to true within the extension configuration you can output the raw content and select your favorite page title via copy/paste.

.. figure:: generate-page-title-suggestions.png
