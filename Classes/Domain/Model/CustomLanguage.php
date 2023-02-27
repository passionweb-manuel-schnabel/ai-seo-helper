<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Domain\Model;


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class CustomLanguage extends AbstractEntity
{
    protected string $isoCode = '';

    protected string $speech = '';

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @param string $isoCode
     */
    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    /**
     * @return string
     */
    public function getSpeech(): string
    {
        return $this->speech;
    }

    /**
     * @param string $speech
     */
    public function setSpeech(string $speech): void
    {
        $this->speech = $speech;
    }
}
