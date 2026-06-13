# Paper LanguageAPI Using
 - Register
```java
@Override
public void onEnable() {
    LangueageAPIHandler.register(this);
}
```

- Change Language
```java
LangueageAPIHandler.setLanguage("ja");
```

- Translate
```java
player.sendMessage(
    LanguageAPI.translate("hello")
);
```

```yaml
Language file:
hello: "Hello World"
```
Output:

Hello World
Placeholder

```yaml
welcome: "Hello {player}"
```

Code:

```java
player.sendMessage(
    LanguageAPI.translate(
        new Translate(
            "welcome",
            Map.of(
                "player",
                player.getName()
            )
        )
    )
);
```

Output:

```txt
Hello Steve
Build
```

## Build plugin:

```txt
./gradlew build
```
Shadow build:
```txt
./gradlew shadowJar
```
Output:
```txt
build/libs/
```
