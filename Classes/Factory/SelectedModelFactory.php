<?php

namespace Passionweb\AiSeoHelper\Factory;

class SelectedModelFactory
{
    public function checkSelectedModel($extConf): bool
    {
        return  $extConf['openAiModel'] === 'gpt-4o-mini' ||
                $extConf['openAiModel'] === 'gpt-4.1-mini' ||
                $extConf['openAiModel'] === 'gpt-4.1' ||
                $extConf['openAiModel'] === 'gpt-5-nano' ||
                $extConf['openAiModel'] === 'gpt-5-mini' ||
                $extConf['openAiModel'] === 'gpt-5' ||
                $extConf['openAiModel'] === 'gpt-5.1' ||
                $extConf['openAiModel'] === 'gpt-5.2' ||
                $extConf['openAiModel'] === 'gpt-oss-20b' ||
                $extConf['openAiModel'] === 'gpt-oss-120b' ||
                $extConf['openAiModel'] === 'gpt-5.4-nano' ||
                $extConf['openAiModel'] === 'gpt-5.4-mini' ||
                $extConf['openAiModel'] === 'gpt-5.4' ||
                $extConf['openAiModel'] === 'gpt-5.5' ||
                $extConf['openAiModel'] === 'gpt-5.6-luna';
    }
}
