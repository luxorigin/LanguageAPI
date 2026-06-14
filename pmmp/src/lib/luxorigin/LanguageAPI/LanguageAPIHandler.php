<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI;

use lib\luxorigin\LanguageAPI\utils\FormatingHelper;
use pocketmine\plugin\PluginBase;

final class LanguageAPIHandler
{
    /** @var PluginBase|null */
    protected static ?PluginBase $registered = null;

    /** @var array<string, array<string, array<string, string>>> */
    protected static array $languages = [];

    /** @var string */
    protected static string $language = "en";

    // NOOP
    private function __construct() {}

    public static function register(PluginBase $plugin): void
    {
        self::$registered = $plugin;
        self::$language = $plugin->getServer()->getLanguage()->getLang();

        foreach (["lang", "languages", "language"] as $folder) {
            $directory = rtrim($plugin->getDataFolder(), "/\\") . DIRECTORY_SEPARATOR . $folder;

            if (!is_dir($directory)) continue;

            foreach (glob($directory . DIRECTORY_SEPARATOR . "*") ?: [] as $filename) {
                self::$languages = FormatingHelper::load(self::$languages, $plugin->getName(), $filename);
            }
        }

        foreach ($plugin->getResources() as $path => $resource) {
            if (!preg_match("#^(lang|language|languages)/#", $path)) continue;

            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $extension = ["json", "yml", "yaml", "ini", "lang"];

            if (!in_array($ext, $extension, true)) {
                continue;
            }
            $target = rtrim($plugin->getDataFolder(), "/\\") . DIRECTORY_SEPARATOR . $path;
            $locale = strtolower(pathinfo($target, PATHINFO_FILENAME));

            if (isset(self::$languages[$plugin->getName()][$locale])) continue;

            if (!file_exists($target)) {
                $plugin->saveResource($target);
            }
            self::$languages = FormatingHelper::load(self::$languages, $plugin->getName(), $target);
        }
    }

    public static function getRegistered(): ?PluginBase
    {
        return self::$registered ?? throw new \LogicException("Plugin registered not found");
    }

    public static function isRegistered(): bool
    {
        return self::$registered instanceof PluginBase;
    }

    public static function getLanguage(): string
    {
        return self::$language ?? "en";
    }

    public static function getCache(): array
    {
        return self::$languages;
    }

    public static function get(string $key): string
    {
        return self::$languages[self::getRegistered()->getName()][self::getLanguage()][$key] ?? $key;
    }

    public static function setLanguage(string $language): void
    {
        $language = strtolower($language);

        if (!isset(self::$languages[self::getRegistered()->getName()][$language])) {
            return;
        }
        self::$language = $language;
    }
}