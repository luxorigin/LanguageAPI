package net.lib.luxorigin.LanguageAPI.utils;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import org.bukkit.configuration.file.YamlConfiguration;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.HashMap;
import java.util.Map;

public final class FormatingHelper {

    // NOOP
    private FormatingHelper() {}

    public static Map<String, String> parseJson(Gson gson, InputStream stream) {
        return gson.fromJson(new InputStreamReader(stream), new TypeToken<Map<String, String>>() {}.getType());
    }

    public static Map<String, String> parseYaml(InputStream stream) {
        YamlConfiguration configuration = YamlConfiguration.loadConfiguration(new InputStreamReader(stream));
        Map<String, String> map = new HashMap<>();

        for (String key : configuration.getKeys(true)) {
            map.put(key, configuration.getString(key));
        }
        return map;
    }

    public static Map<String, String> parseINI(InputStream stream) throws IOException {
        Map<String, String> map = new HashMap<>();
        BufferedReader reader = new BufferedReader(new InputStreamReader(stream));
        String line;

        while ((line = reader.readLine()) != null) {
            line = line.trim();

            if (line.isEmpty() || line.startsWith("#") || !line.contains("=")) {
                continue;
            }
            String[] split = line.split("=", 2);
            map.put(split[0].trim(), split[1].trim());
        }
        return map;
    }
}