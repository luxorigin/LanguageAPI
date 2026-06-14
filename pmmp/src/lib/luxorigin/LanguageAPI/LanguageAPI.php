<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI;

use lib\luxorigin\LanguageAPI\translate\Translate;

final class LanguageAPI
{
    // NOOP
    private function __construct()
    {}

    public static function translate(Translate $translate): string
    {
        $text = LanguageAPIHandler::get($translate->getKey());

        foreach ($translate->getParameters() as $key => $value) {
            $text = str_replace('{' . $key . '}', (string)$value, $text);
        }
        return $text;
    }
}