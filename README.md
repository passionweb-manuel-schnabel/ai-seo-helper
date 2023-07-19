# TYPO3 Extension `AI SEO Helper`

Generates SEO metadata based on page content using AI. Currently, meta description, keywords, page title, Open Graph and Twitter data (titles and descriptions) can be generated using an additional button next to the corresponding text fields. Based on page title and meta description you can fill Open Graph title, Twitter title, Open Graph description and Twitter description too.

## Installation

### Add via composer:

    composer require "passionweb/ai-seo-helper"

* Install the extension via composer
* Flush TYPO3 and PHP Cache
* Add your OpenAI secret key to the extension configuration before using the extension

### Add via TER:

If you want to install the extension via TER you can find detailed instructions [here](https://docs.typo3.org/m/typo3/guide-installation/10.4/en-us/ExtensionInstallation/Index.html).

* Install the extension via TER
* Flush TYPO3 and PHP Cache
* Add your OpenAI secret key to the extension configuration before using the extension

### Further information

The different ways to install an extension and additional detailed information can be found [here](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ExtensionArchitecture/HowTo/ExtensionManagement.html).

## Requirements

You need an OpenAI account and API key. If you have not yet created an account or key, you can do so using the following links.

Source: [Create OpenAI account](https://platform.openai.com/signup "Create OpenAI account")

Source: [Create API key](https://platform.openai.com/account/api-keys "Create API key")

## General information on data generation

The extension currently supports the [GPT-3.5 models](https://platform.openai.com/docs/models/gpt-3-5) and [GPT-4 models](https://platform.openai.com/docs/models/gpt-4) (no snapshots are supported). Based on your individual requirements, different models can lead to different results (also in terms of quality). In addition, other parameters can be modified to further specify the OpenAI requests. You have the possibility to adjust the different models as well as the most of the supported request parameters ([detailed explanation can be found here](https://platform.openai.com/docs/api-reference/completions/create)) in the extension settings.

## Generate meta description (suggestions)

Added an additional button next to the meta description text field. When you click this button, the (text) content of the selected page is generated, and you get meta description suggestions with the help of the AI. By default, the extension prepares the meta description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawMetaDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite meta description via copy/paste.

![Generate meta description suggestions](./Documentation/Editor/generate-meta-description.png)

It can happen that the AI returns texts that exceed the maximum allowed length of the meta description. To additionally check the length of the meta description, the extension ["Yoast SEO for TYPO3"](https://extensions.typo3.org/extension/yoast_seo "Yoast SEO for TYPO3") can be used, for example, or various online tools.

## Generate keywords

Added an additional button next to the keywords text field. When you click this button, the (text) content of the selected page is generated and keywords that is as suitable as possible is created with the help of the AI. Currently, the page must not be deactivated in the backend. Depending on the page size, the process may take a few seconds. However, notifications are used to display appropriate information.

![Generate keywords](./Documentation/Editor/generate-keywords.png)

## Generate page title (suggestions)

Added an additional button next to the seo title text field. When you click this button, the (text) content of the selected page is generated, and you get page title suggestions with the help of the AI. By default, the extension prepares the page title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawPageTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite page title via copy/paste.

![Generate page title suggestions](./Documentation/Editor/generate-page-title-suggestions.png)

## Generate Open Graph title (suggestions)

Added an additional button next to the Open Graph title text field. When you click this button, the (text) content of the selected page is generated, and you get Open Graph title suggestions with the help of the AI. By default, the extension prepares the Open Graph title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawOgTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite Open Graph title via copy/paste.

## Generate Open Graph description (suggestions)

Added an additional button next to the Open Graph description text field. When you click this button, the (text) content of the selected page is generated, and you get Open Graph description suggestions with the help of the AI. By default, the extension prepares the Open Graph description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawOgDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite Open Graph description via copy/paste.

## Generate Twitter title (suggestions)

Added an additional button next to the Twitter title text field. When you click this button, the (text) content of the selected page is generated, and you get Twitter title suggestions with the help of the AI. By default, the extension prepares the Twitter title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawTwitterTitleSuggestions` to true within the extension configuration you can output the raw content and select your favorite Twitter title via copy/paste.

## Generate Twitter description (suggestions)

Added an additional button next to the Twitter description text field. When you click this button, the (text) content of the selected page is generated, and you get Twitter description suggestions with the help of the AI. By default, the extension prepares the Twitter description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. If you set the option `showRawTwitterDescriptionSuggestions` to true within the extension configuration you can output the raw content and select your favorite Twitter description via copy/paste.

## Use page title suggestion for Open Graph and Twitter titles

Since Version 0.5.0 you have the option to copy the selected page title suggestion to the fields for Open Graph and Twitter titles (can be found within the tab "Social media"). Therefore you must enable the option `pageTitleForOgAndTwitter` in the extension settings. If you select a page title the content will be copied to the fields `og_title`and `twitter_title` too.

## Use meta description suggestion for Open Graph and Twitter descriptions

Since Version 0.5.0 you have the option to copy the selected meta description suggestion to the fields for Open Graph and Twitter descriptions (can be found within the tab "Social media"). Therefore you must enable the option `metaDescriptionForOgAndTwitter` in the extension settings. If you select a meta description the content will be copied to the fields `og_description`and `twitter_description` too.

## Getting results in two different ways

Since version 0.3.0 you have two different options to generate the desired data. Both variants adds a ["language suffix"](#how-is-the-language-suffix-determined) to get the response in the language of the analyzed page/content.

### Analyzing the page content based on the text

As already mentioned, this option is primarily limited by the length of the allowed characters per OpenAI request. Furthermore, using this method requires the use of a comparatively large number of tokens.

The following settings are necessary:

- disable the `useUrlForRequest` option in the extension settings
- check if the ISO code(s) of the language configurations is/are present in the predefined fields (if not present, custom languages can be added, see ["Add custom languages"](#add-custom-languages)).
- Definition of the corresponding prompt in English.

The entire prompt is then assembled from the prompt prefix (from the extension settings), the page url and the language suffix (based on the language used on the page). An example of the generated prompt for page title suggestions would look like this (for a German language site):

    1. Suggest page title ideas in bullet point list for the following text (content from extension setting `openAiPromptPrefixPageTitle`)
    2. in German (language suffix based on the language used on the page)
    3. Here comes the page content

    Complete:

    Suggest page title ideas in bullet point list for the following text in German:

    Here comes the page content

### Analyzing the page content by URL

In contrast to the text-based variant, this option uses the URL of the page to analyze the desired data. If you want to use this variant, the following settings are necessary:

- enable the `useUrlForRequest` option in the extension settings
- check if the ISO code(s) of the language configurations is/are present in the predefined fields (if not present, custom languages can be added, see ["Add custom languages"](#add-custom-languages)).
- Definition of the corresponding prompt in English.

The entire prompt is then assembled from the prompt prefix (from the extension settings), the page url and the language suffix (based on the language used on the page). An example of the generated prompt for page title suggestions would look like this (for a German language site):

    1. Suggest page title ideas in bullet point list for (content from extension setting `openAiPromptPrefixPageTitle`)
    2. https://www.example.de/ (page url)
    3. in German (language suffix based on the language used on the page)

    Complete:

    Suggest page title ideas in bullet point list for https://www.example.de/ in German

Requirement is that the page is publicly accessible (hidden pages fail and pages in a local environment lead to poor results).

A major advantage is that this variant saves quite a lot of OpenAI tokens (and thus costs), since only the URL is sent to OpenAI instead of the entire page content

## Extension settings

You can adapt the following parameters to your personal needs. After the first tests, the best results were achieved with the predefined values. However, this is no guarantee that these values will also achieve the best results for you.

### `openAiApiKey`

    # cat=API Key; type=string; label=OpenAI Secret Key
    openAiApiKey = YOUR_API_KEY

Enter your generated OpenAI API key.

### `openAiPromptPrefixMetaDescription`

    # cat=meta description; type=string; label=Prompt-Prefix for meta description suggestions generation
    openAiPromptPrefixMetaDescription = Extract five seo meta descriptions in a bullet point list, each seo meta description in one short sentence and with a maximum of 150 characters or less, for the content of

Enter your instruction for generating meta description suggestions. Since OpenAI calculates the length of the content with tokens (an explanation of the conversion of tokens into characters and sentences can be found [here](https://help.openai.com/en/articles/4936856-what-are-tokens-and-how-to-count-them#:~:text=Tokens%20can%20be%20thought%20of,spaces%20and%20even%20sub%2Dwords. "")) by default, we have to explicitly tell the AI the desired total length and the type of expected creation

### `showRawMetaDescriptionSuggestions`

    #cat=page title; type=boolean; label=Show raw response content of meta description suggestions
    showRawMetaDescriptionSuggestions = 0

By default, the extension prepares the meta description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite meta description via copy/paste.

### `openAiPromptPrefixKeywords`

    # cat=keywords; type=string; label=Prompt-Prefix for keywords generation
    openAiPromptPrefixKeywords = Extract seo keywords from this text

Enter your instruction for generating keywords.

### `replaceTextKeywords`

    # cat=keywords; type=string; label=Replace first part of generated keywords
    replaceTextKeywords = SEO keywords:

The content generated by OpenAI is usually supplemented with a short introduction. Here you can define the part of the generated content that should be removed.

### `openAiPromptPrefixPageTitle`

    #cat=page title; type=string; label=Prompt-Prefix for page title suggestions generation
    openAiPromptPrefixPageTitle = Suggest page title ideas in bullet point list for this text

Enter your instruction for generating page title suggestions (IMPORTANT: response must be a bullet point list as the return is processed that way).

### `showRawPageTitleSuggestions`

    #cat=page title; type=boolean; label=Show raw response content of page title suggestions
    showRawPageTitleSuggestions = 0

By default, the extension prepares the page title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite page title via copy/paste.

### `openAiPromptPrefixOgTitle`

    #cat=open graph; type=string; label=Prompt-Prefix for Open Graph title suggestions generation
    openAiPromptPrefixOgTitle = Suggest Open Graph title ideas in bullet point list for this text

Enter your instruction for generating Open Graph title suggestions (IMPORTANT: response must be a bullet point list as the return is processed that way).

### `showRawOgTitleSuggestions`

    #cat=open graph; type=boolean; label=Show raw response content of Open Graph title suggestions
    showRawOgTitleSuggestions = 0

By default, the extension prepares the Open Graph title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite Open Graph title via copy/paste.

### `openAiPromptPrefixOgDescription`

    # cat=open graph; type=string; label=Prompt-Prefix for Open Graph description suggestions generation
    openAiPromptPrefixOgDescription = Extract five Open Graph descriptions in a bullet point list, each Open Graph description in one short sentence and with a maximum of 150 characters or less, for the content of

Enter your instruction for generating Open Graph description suggestions. Since OpenAI calculates the length of the content with tokens (an explanation of the conversion of tokens into characters and sentences can be found [here](https://help.openai.com/en/articles/4936856-what-are-tokens-and-how-to-count-them#:~:text=Tokens%20can%20be%20thought%20of,spaces%20and%20even%20sub%2Dwords. "")) by default, we have to explicitly tell the AI the desired total length and the type of expected creation

### `showRawOgDescriptionSuggestions`

    #cat=open graph; type=boolean; label=Show raw response content of Open Graph description suggestions
    showRawOgDescriptionSuggestions = 0

By default, the extension prepares the Open Graph description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite Open Graph description via copy/paste.

### `openAiPromptPrefixTwitterTitle`

    #cat=twitter; type=string; label=Prompt-Prefix for Twitter title suggestions generation
    openAiPromptPrefixTwitterTitle = Suggest Twitter title ideas in bullet point list for this text

Enter your instruction for generating Twitter title suggestions (IMPORTANT: response must be a bullet point list as the return is processed that way).

### `showRawTwitterTitleSuggestions`

    #cat=twitter; type=boolean; label=Show raw response content of Twitter title suggestions
    showRawTwitterTitleSuggestions = 0

By default, the extension prepares the Twitter title suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite Twitter title via copy/paste.

### `openAiPromptPrefixTwitterDescription`

    # cat=twitter; type=string; label=Prompt-Prefix for Twitter description suggestions generation
    openAiPromptPrefixTwitterDescription = Extract five Twitter descriptions in a bullet point list, each Twitter description in one short sentence and with a maximum of 150 characters or less, for the content of

Enter your instruction for generating Twitter description suggestions. Since OpenAI calculates the length of the content with tokens (an explanation of the conversion of tokens into characters and sentences can be found [here](https://help.openai.com/en/articles/4936856-what-are-tokens-and-how-to-count-them#:~:text=Tokens%20can%20be%20thought%20of,spaces%20and%20even%20sub%2Dwords. "")) by default, we have to explicitly tell the AI the desired total length and the type of expected creation

### `showRawTwitterDescriptionSuggestions`

    #cat=twitter; type=boolean; label=Show raw response content of Twitter description suggestions
    showRawTwitterDescriptionSuggestions = 0

By default, the extension prepares the Twitter description suggestions in such a way that they can be selected via radio button. If you change the prompt prefix and no bullet point list is returned as a result, display problems can occur here. With this option you can output the raw content and select your favorite Twitter description via copy/paste.

### `pageTitleForOgAndTwitter`

    #cat=open graph & twitter; type=boolean; label=Fill Open Graph and Twitter titles
    pageTitleForOgAndTwitter = 0

Use selected page title suggestion for Open Graph and Twitter titles

### `metaDescriptionForOgAndTwitter`

    #cat=open graph & twitter; type=boolean; label=Fill Open Graph and Twitter descriptions
    metaDescriptionForOgAndTwitter = 0

Use selected meta description suggestion for Open Graph and Twitter descriptions

### `openAiModel`

    # cat=basic request settings; type=string; label=OpenAI Model
    openAiModel = gpt-3.5-turbo

The id of the model which will generate the completion. See [models overview](https://platform.openai.com/docs/models/overview "models overview") for an overview of available models.

### `openAiTemperature`

    # cat=basic request settings; type=double+; label=OpenAI Temperature
    openAiTemperature = 0.5

What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.

### `openAiMaxTokens`

    # cat=basic request settings; type=int+; label=OpenAI Max-Tokens
    openAiMaxTokens = 275

The token ([what are tokens and how to count them](https://help.openai.com/en/articles/4936856-what-are-tokens-and-how-to-count-them#:~:text=Tokens%20can%20be%20thought%20of,spaces%20and%20even%20sub%2Dwords. "")) count of your prompt plus max_tokens cannot exceed the model's context length. Most models have a context length of 2048 tokens (except for the newest models, which support 4096).

### `openAiTopP`

    # cat=basic request settings; type=int+; label=OpenAI Top-P
    openAiTopP = 1

An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.

### `openAiFrequencyPenalty`

    # cat=basic request settings; type=double; label=OpenAI Frequency Penalty
    openAiFrequencyPenalty = 0.8

Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.

### `openAiPresencePenalty`

    # cat=basic request settings; type=double; label=OpenAI Presence Penalty
    openAiPresencePenalty = 0

Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.

### `useUrlForRequest`

    # cat=basic request settings; type=boolean; label=Use always URL for requests
    useUrlForRequest = 1

With this option you can use the corresponding URL of the page for all analyses. As a result, you have to use fewer tokens to carry out your corresponding analyses. IMPORTANT: The page must be publicly accessible (hidden pages fail and pages in a local environment lead to poor results)

## How is the language suffix determined?

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

## Add custom languages

If the desired ISO code and language is not contained, it can be created using a data record "Custom language". The user-defined languages are added automatically (already existing languages are replaced by user-defined languages).

## Extend logic to other fields

Of course, the functionality can also be transferred to other page properties that are not currently taken into account. The following procedure applies to all text input and textarea fields. Additional adjustments must be made for other fields (e.g. image fields) or fields within content elements.

Do not make the changes directly in the extension! Please create your own extension for individual adjustments or add the changes to your sitepackage extension and add/edit the following files:

The following placeholders were used:
*    FIELD_IDENTIFIER: identifier of the field (e.g. twitter_title),
*    FIELD_IDENTIFIER_UPPER_CAMELCASE: identifier of the field in upper camel case (e.g. TwitterTitle),
*    NODE_IDENTIFIER: identifier of the field type of NodeFactory (e.g. aiSeoTwitterTitle)
*    TIMESTAMP: current timestamp as a unique identifier
*    \Vendor\Package\: replace this with your own vendor and package name


### Add TCA configuration to Configuration/TCA/Overrides/pages.php

    $GLOBALS['TCA']['pages']['columns']['FIELD_IDENTIFIER']['config'] = array_merge_recursive(
        $GLOBALS['TCA']['pages']['columns']['FIELD_IDENTIFIER']['config'],
        [
            'fieldControl' => [
                'importControl' => [
                    'renderType' => 'NODE_IDENTIFIER'
                ]
            ]
        ]
    );

### Add FormEngine fieldControl (e.g. to Classes/FormEngine/FieldControl/AiSeoFIELD_IDENTIFIER_UPPER_CAMELCASE.php)

    class AiSeoFIELD_IDENTIFIER_UPPER_CAMELCASE extends AbstractNode
    {
        public function render(): array
        {
            $resultArray = [
                'iconIdentifier' => 'actions-document-synchronize',
                'title' => 'Your custom title',
                'linkAttributes' => [
                    'id' => 'FIELD_IDENTIFIER_generation',
                    'class' => 'ai-seo-helper-suggestions-generation-btn',
                    'data-page-id' => $this->data['databaseRow']['uid'],
                    'data-field-name' => 'FIELD_IDENTIFIER'
                ]
            ];

            $javaScriptModuleService = GeneralUtility::makeInstance(JavaScriptModuleService::class);

            return array_merge($resultArray, $javaScriptModuleService->addModules());
        }
    }

### Add registration in NodeFactory to ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][TIMESTAMP] = [
        'nodeName' => 'NODE_IDENTIFIER',
        'priority' => 30,
        'class' => \Vendor\Package\FormEngine\FieldControl\AiSeoFIELD_IDENTIFIER_UPPER_CAMELCASE::class
    ];

### Add further configuration settings to ext_conf_template.txt

    #cat=custom category; type=string; label=Your custom title
    openAiPromptPrefixFIELD_IDENTIFIER_UPPER_CAMELCASE = Your custom prompt

### Add function to controller (e.g. to Classes/Controller/Ajax/AiController.php)

    public function generateFIELD_IDENTIFIER_UPPER_CAMELCASEAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateSuggestions($request, 'FIELD_IDENTIFIER_UPPER_CAMELCASE');
    }

The function generateSuggestions() can be used from `\Passionweb\AiSeoHelper\Service\ContentService`

### Add ajax route to Configuration/Backend/AjaxRoutes.php

    return [
        'FIELD_IDENTIFIER_generation' => [
            'path' => 'CUSTOM_PATH',
            'target' => \Vendor\Package\Controller\Ajax\AiController::class . '::generateFIELD_IDENTIFIER_UPPER_CAMELCASEAction'
        ],
    ];

Once all adjustments have been made, flush the TYPO3 and PHP cache and test if everything works as desired.

## Troubleshooting and logging

If something does not work as expected take a look at the log file first.
Every problem is logged to the TYPO3 log (normally found in `var/log/typo3_*.log`)

## Notices to keep in mind

Just like this extension, OpenAI is still in development mode and not fully mature. For this reason, we urgently advise you to check all generated texts for correctness before saving them and to make any necessary adjustments!

The OpenAI API (currently) limits the maximum number of tokens per request depending on the model used (e.g. "text-davinci-003" is limited to 4096 tokens). You can find a detailed overview of models and the maximum number of tokens here:

[https://platform.openai.com/docs/models/gpt-3](https://platform.openai.com/docs/models/gpt-3)

Based on the current status of the extension, it is unfortunately not yet possible to analyze larger texts.


## Achieving more together or Feedback, Feedback, Feedback

I'm grateful for any feedback! Be it suggestions for improvement, extension requests or just a (constructive) feedback on how good or crappy the extension is.

Feel free to send me your feedback to [service@passionweb.de](mailto:service@passionweb.de "Send Feedback") or [contact me on Slack](https://typo3.slack.com/team/U02FG49J4TG "Contact me on Slack")
