<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI;

use lib\luxorigin\LanguageAPI\translate\Translate;
use pocketmine\Server;

final class LanguageAPI
{
    /** @var string */
    protected string $defaultLanguage = "en";

    public function __construct()
    {
        $this->defaultLanguage = Server::getInstance()->getLanguage()->getLang() ?: "en";
    }

    public function getDefault(): string
    {
        return $this->defaultLanguage;
    }

    public function setDefault(string $language): void
    {
        $this->defaultLanguage = $language;
    }

    public function resolve(Translate $translate): string
    {
        $lang = LanguageHandler::getLanguage();
        $text = $lang[$this->defaultLanguage][$translate->getKey()] ?? $translate->getKey();

        foreach ($translate->getParameters() as $key => $value) {
            $text = str_replace($key, (string)$value, $text);
        }
        return $text;
    }
}