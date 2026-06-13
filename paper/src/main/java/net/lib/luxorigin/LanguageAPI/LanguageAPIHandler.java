package net.lib.luxorigin.LanguageAPI;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import lombok.Getter;
import net.lib.luxorigin.LanguageAPI.utils.FormatingHelper;
import org.bukkit.plugin.java.JavaPlugin;

import java.io.File;
import java.io.InputStream;
import java.util.Enumeration;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;
import java.util.jar.JarEntry;
import java.util.jar.JarFile;

public final class LanguageAPIHandler {

    // NOOP
    private LanguageAPIHandler() {}

    private static final Gson gson = new GsonBuilder().setPrettyPrinting().create();

    @Getter
    private static JavaPlugin registered;
    @Getter
    private static final Map<JavaPlugin, Map<String, Map<String, String>>> cache = new HashMap<>();

    @Getter
    private static String language = Locale.getDefault().getLanguage().toLowerCase();

    public static void register(JavaPlugin plugin) {
        try {
            Map<String, Map<String, String>> langs = new HashMap<>();
            File jar = new File(plugin.getClass().getProtectionDomain().getCodeSource().getLocation().toURI());

            try (JarFile jarFile = new JarFile(jar)) {
                Enumeration<JarEntry> entries = jarFile.entries();

                while (entries.hasMoreElements()) {
                    JarEntry entry = entries.nextElement();
                    String path = entry.getName();

                    if (!path.startsWith("lang/") && !path.startsWith("languages/") && !path.startsWith("language/") || entry.isDirectory()) {
                        continue;
                    }
                    String file = path.substring(path.indexOf("/") + 1);
                    String locale = file.substring(0, file.lastIndexOf("."));
                    String ext = file.substring(file.lastIndexOf(".") + 1);

                    try (InputStream stream = plugin.getResource(path)) {
                        if (stream == null) continue;

                        if (langs.containsKey(locale)) {
                            throw new RuntimeException("Duplicated locale : " + locale);
                        }

                        langs.put(locale, switch (ext) {
                            case "json" -> FormatingHelper.parseJson(gson, stream);
                            case "yml", "yaml" -> FormatingHelper.parseYaml(stream);
                            case "ini", "lang" -> FormatingHelper.parseINI(stream);
                            default -> Map.of();
                        });
                    } catch (Exception e) {
                        throw new RuntimeException("Language load failed", e);
                    }
                }
            }
            cache.put(plugin, langs);
            registered = plugin;
        } catch (Exception e) {
            throw new RuntimeException("Language load failed", e);
        }
    }

    public static void setLanguage(String language) {
        language = language.toLowerCase();

        if (cache.getOrDefault(registered, Map.of()).containsKey(language)) {
            LanguageAPIHandler.language = language;
        }
    }
}