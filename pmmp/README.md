# PocketMine-MP Language Using

- Register
```php
protected function onEnable(): void {
    LanguageAPI::register($this);
}
```
- Change Language
```php
LanguageAPI::setLanguage("ko");
```

- Translate
```php
$this->getLogger()->info(
    LanguageAPI::translate(
        "hello"
    )
);
```

- Language
```txt
hello: "안녕하세요"
```

Output:

안녕하세요
Placeholder

- Language
```yaml
welcome: "안녕하세요 {player}"
```
Code:

```php
LanguageAPI::translate(
    new Translate(
        "welcome",
        ["player" => $player->getName()]
    )
);
```

Output:

```txt
안녕하세요 Steve
Build
```
Output:

Hello Aiden
