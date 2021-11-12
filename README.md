# Simple Fields

This package provides a simple solution for working with backend defined fields.
Use cases:
* Backend defined forms fields
* Defined survey questionnaire with strict input types and valid values
* Define configuration application settings options with default values
* Fetch form data (including input type, validation rules, etc) from the backend for frontend display.

**Notes**
* This package was inspired by [Laravel Nova](https://nova.laravel.com/) fields.
* Field properties are aimed to be consistent with [Vuetify](https://vuetifyjs.com/en/components) form input component properties.


```php
$field = Boolean::make('Enable notification')->default(false);
```

## Installation

```bash
composer require moirei/fields
```

## Usage

```php
use MOIREI\Fields\Inputs\Field;
use MOIREI\Fields\Inputs\{Text, Number, Select, Radio, Textarea};
...

$survey_questions = [
    Text::make('Whats your name?', 'name')
        ->rules('max:24')
        ->placeholder('John Doe')
        ->toArray(),

    Number::make('How old are you?', 'age')
        ->min(18)
        ->toArray(),

    Select::make('Gender')
        ->options([
            'Fridge',
            'Bridge',
            [ 'text' => 'I prefer not to say', 'value' => 'other' ],
        ])
        ->default('other')
        ->toArray(),

    Radio::make('Can keep you data for future promos?', 'subscribe')
        ->trueValue('Yes plez')
        ->falseValue('No thanks')
        ->toArray(),

    Textarea::make('More about yourself?', 'more')
        ->rows(10)
        ->hint('In a few words. Feel free to elaborate on the above.')
        ->persistentHint()
        ->toArray(),
];
```

### Validation

```php
$field = Text::make('Whats your name?', 'name')
        ->rules('max:24')
        ->placeholder('John Doe');

$valid = $field->validate('James Bond');
// or assert and throw exception
$field->validate('James Bond', true)
```

#### Validate multiple values
```php
$fields = [
    Text::make('Whats your name?', 'name')
        ->rules('max:24')
        ->placeholder('John Doe'),
    ...
];

$returnOnlyValidated = true;

$input = Field::validateInput($request->all(), $fields, $returnOnlyValidated)
```

## Tests
```bash
composer test
```