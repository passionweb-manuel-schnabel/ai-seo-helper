<?php

namespace Passionweb\AiSeoHelper\Factory;

class SelectedModelFactory
{
    public function checkSelectedModel($extConf): bool
    {
        return  $extConf['openAiModel'] === 'gpt-3.5-turbo' ||
                $extConf['openAiModel'] === 'gpt-3.5-turbo-16k' ||
                $extConf['openAiModel'] === 'gpt-4' ||
                $extConf['openAiModel'] === 'gpt-4-32k';
    }
}
