.. include:: ../Includes.txt

.. _editors_manual:

Editors Manual
==============

Target group: **Editors**

.. _general_information_on_data_generation:

General information on data generation
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension currently supports the `GPT-3.5 models <https://platform.openai.com/docs/models#gpt-3-5-turbo>`_, `GPT-4 models <https://platform.openai.com/docs/models#gpt-4-turbo-and-gpt-4>`_ and `GPT-4 o mini <https://platform.openai.com/docs/models#gpt-4o-mini>`_ (no snapshots are supported). Please also note possible restrictions when using the "GPT-4" models (see :ref:`possible_limitations_when_using_the_gpt_4_model`).

Based on your individual requirements, different models can lead to different results (also in terms of quality). In addition, other parameters can be modified to further specify the OpenAI requests. You have the possibility to adjust the different models as well as the most of the supported request parameters (`detailed explanation can be found here <https://platform.openai.com/docs/api-reference/completions/create>`_) in the extension settings.

.. _generate_data_for_page_properties:

Generate data for page properties
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. _generate_meta_description_suggestions:

Generate meta description (suggestions)
---------------------------------------

Added an additional button next to the meta description text field. When you click this button, the (text) content of the selected page is generated, and you get meta description suggestions with the help of the AI. By default, the extension prepares the meta description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawMetaDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite meta description via copy/paste.

.. figure:: generate-meta-description.png

It can happen that the AI returns texts that exceed the maximum allowed length of the meta description. To additionally check the length of the meta description, the extension `Yoast SEO for TYPO3 <https://extensions.typo3.org/extension/yoast_seo>`_ can be used, for example, or various online tools.

.. _generate_keywords:

Generate keywords
-----------------

Added an additional button next to the keywords text field. When you click this button, the (text) content of the selected page is generated and keywords that is as suitable as possible is created with the help of the AI. Currently, the page must not be deactivated in the backend. Depending on the page size, the process may take a few seconds. However, notifications are used to display appropriate information.

.. figure:: generate-keywords.png

.. _generate_page_title_suggestions:

Generate page title (suggestions)
---------------------------------

Added an additional button next to the seo title text field. When you click this button, the (text) content of the selected page is generated and you get page title suggestions with the help of the AI. By default, the extension prepares the page title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawPageTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite page title via copy/paste.

.. figure:: generate-page-title-suggestions.png

.. _generate_open_graph_title_suggestions:

Generate Open Graph title (suggestions)
---------------------------------------

Added an additional button next to the Open Graph title text field. When you click this button, the (text) content of the selected page is generated, and you get Open Graph title suggestions with the help of the AI. By default, the extension prepares the Open Graph title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawOgTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite Open Graph title via copy/paste.

.. _generate_open_graph_descriptions_suggestions:

Generate Open Graph description (suggestions)
---------------------------------------------

Added an additional button next to the Open Graph description text field. When you click this button, the (text) content of the selected page is generated, and you get Open Graph description suggestions with the help of the AI. By default, the extension prepares the Open Graph description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawOgDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite Open Graph description via copy/paste.

.. _generate_twitter_title_suggestions:

Generate Twitter title (suggestions)
------------------------------------

Added an additional button next to the Twitter title text field. When you click this button, the (text) content of the selected page is generated, and you get Twitter title suggestions with the help of the AI. By default, the extension prepares the Twitter title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawTwitterTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite Twitter title via copy/paste.

.. _generate_twitter_description_suggestions:

Generate Twitter description (suggestions)
------------------------------------------

Added an additional button next to the Twitter description text field. When you click this button, the (text) content of the selected page is generated, and you get Twitter description suggestions with the help of the AI. By default, the extension prepares the Twitter description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawTwitterDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite Twitter description via copy/paste.

.. _use_page_title_suggestions_for_open_graph_and_twitter_titles:

Use page title suggestion for Open Graph and Twitter titles
-----------------------------------------------------------

Since Version 0.5.0 you have the option to copy the selected page title suggestion to the fields for Open Graph and Twitter titles (can be found within the tab "Social media"). Therefore you must enable the option `pageTitleForOgAndTwitter` in the extension settings. If you select a page title the content will be copied to the fields `og_title`and `twitter_title` too.

.. _use_page_title_suggestions_for_open_graph_and_twitter_descriptions:

Use meta description suggestion for Open Graph and Twitter descriptions
-----------------------------------------------------------------------

Since Version 0.5.0 you have the option to copy the selected meta description suggestion to the fields for Open Graph and Twitter descriptions (can be found within the tab "Social media"). Therefore you must enable the option `metaDescriptionForOgAndTwitter` in the extension settings. If you select a meta description the content will be copied to the fields `og_description`and `twitter_description` too.

.. _generate_data_for_articles_of_ext_news:

Generate data for articles of EXT:news
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

With version 0.6.0 the compatibility to EXT:news was added. Currently, the following metadata can be generated:

.. _generate_news_meta_description_suggestions:

Generate meta description (suggestions)
---------------------------------------

Added an additional button next to the meta description text field. When you click this button, the (text) content of the selected news article is generated, and you get meta description suggestions with the help of the AI. By default, the extension prepares the meta description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawNewsMetaDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite meta description via copy/paste.

It can happen that the AI returns texts that exceed the maximum allowed length of the meta description. To additionally check the length of the meta description, the extension ["Yoast SEO for TYPO3"](https://extensions.typo3.org/extension/yoast_seo "Yoast SEO for TYPO3") can be used, for example, or various online tools.

.. _generate_news_keywords:

Generate keywords
-----------------

Added an additional button next to the keywords text field. When you click this button, the (text) content of the selected news article is generated and keywords that is as suitable as possible is created with the help of the AI. Currently, the page must not be deactivated in the backend. Depending on the page size, the process may take a few seconds. However, notifications are used to display appropriate information.

.. _generate_news_alternative_title_suggestions:

Generate alternative title (suggestions)
----------------------------------------

Added an additional button next to the alternative title text field. When you click this button, the (text) content of the selected news article is generated, and you get alternative title suggestions with the help of the AI. By default, the extension prepares the alternative title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawNewsAlternativeTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite page title via copy/paste.

.. _getting_results_in_two_different_ways:

Getting results in two different ways
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Since version 0.3.0 you have two different options to generate the desired data. Both variants adds a ["language suffix"](#how-is-the-language-suffix-determined) to get the response in the language of the analyzed page/content.

.. _analyzing_page_content_by_text:

Analyzing the page content based on the text
--------------------------------------------

As already mentioned, this option is primarily limited by the length of the allowed characters per OpenAI request. Furthermore, using this method requires the use of a comparatively large number of tokens.

The following settings are necessary:

- disable the `useUrlForRequest` option in the extension settings
- check if the ISO code(s) of the language configurations is/are present in the predefined fields (if not present, custom languages can be added, see :ref:`Add custom languages <add_custom_languages>`).
- Definition of the corresponding prompt in English.

The entire prompt is then assembled from the prompt prefix (from the extension settings), the page url and the language suffix (based on the language used on the page). An example of the generated prompt for page title suggestions would look like this (for a German language site):

    1. Suggest page title ideas in bullet point list for the following text (content from extension setting `openAiPromptPrefixPageTitle`)
    2. in German (language suffix based on the language used on the page)
    3. Here comes the page content

    Complete:

    Suggest page title ideas in bullet point list for the following text in German:

    Here comes the page content

.. _analyzing_page_content_by_url:

Analyzing the page content by URL
---------------------------------

In contrast to the text-based variant, this option uses the URL of the page to analyze the desired data. If you want to use this variant, the following settings are necessary:

- enable the `useUrlForRequest` option in the extension settings
- check if the ISO code(s) of the language configurations is/are present in the predefined fields (if not present, custom languages can be added, see :ref:`Add custom languages <add_custom_languages>`).
- Definition of the corresponding prompt in English.

The entire prompt is then assembled from the prompt prefix (from the extension settings), the page url and the language suffix (based on the language used on the page). An example of the generated prompt for page title suggestions would look like this (for a German language site):

    1. Suggest page title ideas in bullet point list for (content from extension setting `openAiPromptPrefixPageTitle`)
    2. https://www.example.de/ (page url)
    3. in German (language suffix based on the language used on the page)

    Complete:

    Suggest page title ideas in bullet point list for https://www.example.de/ in German

Requirement is that the page is publicly accessible (hidden pages fail and pages in a local environment lead to poor results).

A major advantage is that this variant saves quite a lot of OpenAI tokens (and thus costs), since only the URL is sent to OpenAI instead of the entire page content

.. _how_is_the_language_suffix_determined:

How is the language suffix determined?
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The root page of the page to be analyzed is determined. Based on this, the ISO code used (the `iso-639-1` field of the corresponding language from `config.yaml) is determined.
The corresponding language has already been created for the conventional ISO codes. The following ISO codes and languages are already stored:

*    'en' => 'English',
*    'us' => 'English',
*    'gb' => 'English',
*    'de' => 'German',
*    'at' => 'German',
*    'ch' => 'German',
*    'fr' => 'French',
*    'nl' => 'Dutch',
*    'be' => 'Belgian',
*    'es' => 'Spanish',
*    'pl' => 'Polish',
*    'cz' => 'Czech',
*    'sk' => 'Slovak',
*    'si' => 'Slovenian',
*    'ro' => 'Romanian',
*    'ua' => 'Ukrainian',
*    'it' => 'Italian',
*    'se' => 'Swedish',
*    'no' => 'Norwegian',
*    'fi' => 'Finnish',
*    'dk' => 'Danish',
*    'jp' => 'Japanese',
*    'cn' => 'Chinese'

.. _add_custom_languages:

Add custom languages
^^^^^^^^^^^^^^^^^^^^

If the desired ISO code and language is not contained, it can be created using a data record "Custom language". The user-defined languages are added automatically (already existing languages are replaced by user-defined languages).
