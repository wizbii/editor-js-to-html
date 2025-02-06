# EditorJs to HTML

Php library to render EditorJs to HTML.

## Installation

You can install the library via Composer:

```bash
composer require wizbii/editor-js-to-html
```

## Usage

```php
use Wizbii\EditorJsToHtml\EditorJsToHtml;

$editorJs = '{
    "time": 1724416790049,
    "blocks": [
        {
            "id": "I0aXLNrk3g",
            "type": "header",
            "data": {
                "text": "Question n°1",
                "level": 1
            }
        },
        {
            "id": "I0aXsL7VIq",
            "type": "paragraph",
            "data": {
                "text": "Veuillez indiquer votre date de naissance."
            }
        }
    ],
    "version": "2.29.1"
}';

echo EditorJsHelper::renderEditorJsToHtml($editorJs);
```

## Running the tests

You can run the tests with PHPUnit:
```bash
composer test
```

For test coverage:
```bash
composer test-coverage
```

## Code quality

To check for code quality issues, you can use the following commands:
```bash
composer dev:cs
```

To automatically fix code style issues:
```bash
composer cs:fix
composer rector:fix
```

## Authors

Sylvain DEPARTE - sylvain.departe@wizbii.com

## License

This project is licensed under the MIT License
