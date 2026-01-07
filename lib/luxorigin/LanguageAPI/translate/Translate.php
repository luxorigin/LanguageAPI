<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI\translate;

readonly class Translate
{
    public function __construct(
        protected string $key,
        protected array $parameters = []
    ) {}

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}