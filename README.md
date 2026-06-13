# LanguageAPI
Simple multi-language API for Paper &amp; PocketMine-MP.

## Supports
- JSON
- YAML / YML
- INI
- LANG
Languages are loaded automatically from plugin resources.

## Folder Structure
resources/
└── lang/
    ├── en.yml
    ├── ko.json
    ├── ja.ini
    └── zh.lang

Language file name becomes locale.

Example:

ko.yml
→ locale = ko

ja.json
→ locale = ja
