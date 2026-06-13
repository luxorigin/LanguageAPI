package net.lib.luxorigin.LanguageAPI;

import net.lib.luxorigin.LanguageAPI.translate.Translate;

import java.util.Map;

final public class LanguageAPI {

    // NOOP
    private LanguageAPI() {}

    public static String translate(String key) {
        return LanguageAPIHandler
                .getCache()
                .getOrDefault(LanguageAPIHandler.getRegistered(), Map.of())
                .getOrDefault(LanguageAPIHandler.getLanguage(), Map.of())
                .getOrDefault(key, key);
    }

    public static String translate(Translate translate) {
        String text = translate(translate.getKey());

        for (var entry : translate.getTranslate().entrySet()) {
            text = text.replace("{" + entry.getKey() + "}", entry.getValue());
        }
        return text;
    }
}
