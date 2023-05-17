.. include:: ../Includes.txt

.. _developers_manual:

Developers Manual
=================

Target group: **Developers**

.. _extend_logic_to_other_fields:

Extend logic to other fields
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Of course, the functionality can also be transferred to other page properties that are not currently taken into account. The following procedure applies to all text input and textarea fields. Additional adjustments must be made for other fields (e.g. image fields) or fields within content elements.

Do not make the changes directly in the extension! Please create your own extension for individual adjustments or add the changes to your sitepackage extension and add/edit the following files:

The following placeholders were used:

*    FIELD_IDENTIFIER: identifier of the field (e.g. twitter_title),
*    FIELD_IDENTIFIER_UPPER_CAMELCASE: identifier of the field in upper camel case (e.g. TwitterTitle),
*    NODE_IDENTIFIER: identifier of the field type of NodeFactory (e.g. aiSeoTwitterTitle)
*    TIMESTAMP: current timestamp as a unique identifier
*    \Vendor\Package\: replace this with your own vendor and package name


Add TCA configuration to Configuration/TCA/Overrides/pages.php
--------------------------------------------------------------

.. code-block:: php

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

Add FormEngine fieldControl (e.g. to Classes/FormEngine/FieldControl/AiSeoFIELD_IDENTIFIER_UPPER_CAMELCASE.php)
---------------------------------------------------------------------------------------------------------------

.. code-block:: php

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

Add registration in NodeFactory to ext_localconf.php
----------------------------------------------------

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][TIMESTAMP] = [
        'nodeName' => 'NODE_IDENTIFIER',
        'priority' => 30,
        'class' => \Vendor\Package\FormEngine\FieldControl\AiSeoFIELD_IDENTIFIER_UPPER_CAMELCASE::class
    ];

Add further configuration settings to ext_conf_template.txt
-----------------------------------------------------------

.. code-block:: none

    #cat=custom category; type=string; label=Your custom title
    openAiPromptPrefixFIELD_IDENTIFIER_UPPER_CAMELCASE = Your custom prompt

Add function to controller (e.g. to Classes/Controller/Ajax/AiController.php)
-----------------------------------------------------------------------------

.. code-block:: php

    public function generateFIELD_IDENTIFIER_UPPER_CAMELCASEAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateSuggestions($request, 'FIELD_IDENTIFIER_UPPER_CAMELCASE');
    }

The function generateSuggestions() can be used from :php:`\Passionweb\AiSeoHelper\Service\ContentService`

Add ajax route to Configuration/Backend/AjaxRoutes.php
------------------------------------------------------

.. code-block:: php

    return [
        'FIELD_IDENTIFIER_generation' => [
            'path' => 'CUSTOM_PATH',
            'target' => \Vendor\Package\Controller\Ajax\AiController::class . '::generateFIELD_IDENTIFIER_UPPER_CAMELCASEAction'
        ],
    ];

Once all adjustments have been made, flush the TYPO3 and PHP cache and test if everything works as desired.
