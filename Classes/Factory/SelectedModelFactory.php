<?php

namespace Passionweb\AiSeoHelper\Factory;

class SelectedModelFactory
{
    public function checkSelectedModel($extConf): bool
    {
        return  $extConf['openAiModel'] === 'gpt-3.5-turbo-1106' ||
                $extConf['openAiModel'] === 'gpt-3.5-turbo' ||
                $extConf['openAiModel'] === 'gpt-3.5-turbo-0125' ||
                $extConf['openAiModel'] === 'gpt-4-1106-preview' ||
                $extConf['openAiModel'] === 'gpt-4-turbo-preview' ||
                $extConf['openAiModel'] === 'gpt-4-turbo' ||
                $extConf['openAiModel'] === 'gpt-4o-mini';
    }
}
