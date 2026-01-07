<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI\trait;

use lib\luxorigin\LanguageAPI\LanguageAPI;
use lib\luxorigin\LanguageAPI\translate\Translate;

trait Translatable
{
    private ?LanguageAPI $api = null;

    public function getLanguage(): LanguageAPI
    {
        if ($this->api == null) {
            $this->api = new LanguageAPI();
        }
        return new LanguageAPI();
    }

    public function translate(Translate $translate): void
    {
        $this->getLanguage()->resolve($translate);
    }

    public function resolve(string $key, array $parameters = []): void
    {
        $this->getLanguage()->resolve(new Translate($key, $parameters));
    }
}