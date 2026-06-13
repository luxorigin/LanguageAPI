package net.lib.luxorigin.LanguageAPI.translate;

import lombok.Getter;

import java.util.Map;

@Getter
public class Translate {

    private final String key;
    private final Map<String, String> translate;

    public Translate(String key, Map<String, String> translate) {
        this.key = key;
        this.translate = translate;
    }
}