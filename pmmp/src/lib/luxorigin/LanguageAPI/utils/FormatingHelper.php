<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI\utils;

final class FormatingHelper
{
    // NOOP
    private function __construct() {}

    public static function load(array $languages, string $plugin, string $file): array
    {
        $locale = strtolower(pathinfo($file, PATHINFO_FILENAME));

        if (isset($languages[$plugin][$locale])) {
            throw new \LogicException("Duplicate language file found : " . $plugin . "/" . $locale);
        }
        $languages[$plugin][$locale] = match (strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
            "json" => self::parseJSON($file),
            "yml", "yaml" => self::parseYAML($file),
            "lang", "ini"  => self::parseINI($file),
            default => throw new \LogicException("Invalid language file : " . $plugin . "/" . $locale),
        };
        return $languages;
    }

    public static function parseJSON(string $json): array
    {
        $data = json_decode(file_get_contents($json) ?: "", true);
        return is_array($data) ? $data : [];
    }

    public static function parseYAML(string $file): array
    {
        if (function_exists("yaml_parse_file")) {
            $data = yaml_parse_file($file);
            return is_array($data) ? $data : [];
        }
        return [];
    }

    public static function parseINI(string $file): array
    {
        return parse_ini_file($file) ?: [];
    }
}