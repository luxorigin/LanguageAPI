<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI\traits;

use lib\luxorigin\LanguageAPI\LanguageAPI;
use lib\luxorigin\LanguageAPI\translate\Translate;

trait Translatable
{
    public function translate(Translate $translate): string
    {
        return LanguageAPI::translate($translate);
    }

    public function resolve(string $key, array $parameters = []): string
    {
        return LanguageAPI::translate(new Translate($key, $parameters));
    }
}