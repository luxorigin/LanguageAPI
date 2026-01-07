<?php

declare(strict_types=1);

namespace lib\luxorigin\LanguageAPI;

use pocketmine\plugin\PluginBase;
use Symfony\Component\Filesystem\Path;

final class LanguageHandler
{
    /** @var PluginBase|null */
    protected static ?PluginBase $plugin = null;

    /**
     * @var array<string, array<string, string>>
     */
    protected static array $languages = [];

    public static function register(PluginBase $plugin): void
    {
        $dir = Path::join($plugin->getDataFolder());

        if (is_dir($dir)) {
            foreach (glob($dir . "*.json") as $file) {
                self::load(basename($file, ".json"), file_get_contents($file, true));
            }
            return;
        }

        foreach ($plugin->getResources() as $path => $resource) {
            if (!str_starts_with($path, "language/") || !str_ends_with($path, ".json")) {
                continue;
            }
            $language = basename($path, ".json");
            self::load($language, $resource->getExtension());
        }
        self::$plugin = $plugin;
    }

    private static function load(string $language, string $json): void
    {
        $data = json_decode($json, true);
        if (!is_array($data)) return;
        self::$languages[$language] = $data;
    }

    public static function getLanguages(): array
    {
        return self::$languages;
    }

    public static function getLanguage(): array
    {
        return self::$languages[self::$plugin->getName()];
    }

    public function isRegistered(): bool
    {
        return self::$plugin instanceof PluginBase;
    }

    public static function getRegistered(): PluginBase
    {
        return self::$plugin ?? throw new \LogicException("Cannot obtain registrant before registration");
    }
}