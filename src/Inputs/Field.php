<?php

namespace MOIREI\Fields\Inputs;

use Closure;
use Illuminate\Contracts\Validation\Validator as IValidator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use JsonSerializable;

abstract class Field implements JsonSerializable
{
    /**
     * The field's input.
     *
     * @var string
     */
    public $input = 'text';

    /**
     * The displayable name of the field.
     *
     * @var string
     */
    public $label;

    /**
     * The attribute name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * Placeholder for the field.
     *
     * @var bool
     */
    public $placeholder = '';

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules = ['nullable'];

    /**
     * Indicates if the field is read-only.
     *
     * @var bool
     */
    public $readonly = false;

    /**
     * Indicates if the field is required.
     *
     * @var bool
     */
    public $required = false;

    /**
     * Indicates if the field is nullable.
     *
     * @var bool
     */
    public $nullable = false;

    /**
     * The default value if left empty.
     *
     * @var mixed
     */
    public $default = null;

    /**
     * Fields that are local to the class
     *
     * @var string[]
     */
    protected array $localFields = ['label', 'name', 'input', 'placeholder', 'rules', 'readonly', 'required', 'nullable', 'default'];

    /**
     * Define extra local fields without modifying localFields
     *
     * @var string[]
     */
    protected array $extraLocalFields = [];

    /**
     * The meta data for the element.
     *
     * @var array
     */
    public $meta = [];

    /**
     * Create a new field.
     *
     * @param  string  $label
     * @param  string|null  $name
     * @return void
     */
    public function __construct($label, $name = null)
    {
        $this->label = $label;
        $this->name = $name ?? str_replace(' ', '_', Str::lower($label));
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Create a new element from attributes.
     *
     * @param array $attributes
     * @return static
     */
    public static function from(array $attributes)
    {
        return (new static($attributes['label']))->fill($attributes);
    }

    /**
     * Fill the field attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        $localFields = $this->getLocalFields();

        foreach ($localFields as $attribute) {
            if (!Arr::has($attributes, $attribute)) {
                continue;
            }
            $this->{$attribute} = Arr::get($attributes, $attribute);
        }
        $this->meta = Arr::except($attributes, $localFields);

        return $this;
    }

    /**
     * Set the name for the field.
     *
     * @param  string  $name
     * @return $this
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the label value for the field.
     *
     * @param  string  $label
     * @return $this
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the input value for the field.
     *
     * @param  string  $input
     * @return $this
     */
    public function input(string $input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Set the placeholder value for the field.
     *
     * @param  string  $placeholder
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Set the default value for the field.
     *
     * @param  string  $helpText
     * @return $this
     */
    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get the default value for the field.
     *
     * @param  string  $helpText
     * @return $this
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set the tip (help) text for the field.
     *
     * @param  string  $helpText
     * @return $this
     */
    public function hint(string $hint)
    {
        return $this->withMeta(['hint' => $hint]);
    }

    /**
     * Set the help text for the field.
     *
     * @param  string  $helpText
     * @return $this
     */
    public function help(string $helpText)
    {
        return $this->hint($helpText);
    }

    /**
     * Persist hint for the field.
     *
     * @param  string  $persistentHint
     * @return $this
     */
    public function persistentHint(bool $persistentHint = true)
    {
        return $this->withMeta(['persistentHint' => $persistentHint]);
    }

    /**
     * Get additional meta information to merge with the element payload.
     *
     * @param string $key
     * @param mixed $default
     * @return array
     */
    public function meta(string $key = null, $default = null)
    {
        if ($key) {
            return Arr::get($this->meta, $key, $default);
        }

        return $this->meta;
    }

    /**
     * Set additional meta information for the element.
     *
     * @param  array  $meta
     * @return $this
     */
    public function withMeta(array $meta)
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    /**
     * Set the validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return $this
     */
    public function rules($rules)
    {
        $this->rules = array_map(
            fn ($rule) => (string)$rule,
            is_array($rules) ? $rules : func_get_args()
        );

        return $this;
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return $this
     */
    public function creationRules($rules)
    {
        $rules = array_map(
            fn ($rule) => (string)$rule,
            is_array($rules) ? $rules : func_get_args()
        );
        return $this->withMeta(['creationRules' => $rules]);
    }

    /**
     * Set the update validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return $this
     */
    public function updateRules($rules)
    {
        $rules = array_map(
            fn ($rule) => (string)$rule,
            is_array($rules) ? $rules : func_get_args()
        );
        return $this->withMeta(['updateRules' => $rules]);
    }

    /**
     * Indicate that the field should be read-only.
     *
     * @param  bool  $readonly
     * @param  array|Closure  $values
     * @return $this
     */
    public function readonly($readonly = true)
    {
        $this->readonly = $readonly;

        return $this;
    }

    /**
     * Indicate that the field should be a required field.
     *
     * @param  bool  $required
     * @param  array|Closure  $values
     * @return $this
     */
    public function required($required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Indicate that the field should be nullable.
     *
     * @param  bool  $nullable
     * @param  array|Closure  $values
     * @return $this
     */
    public function nullable($nullable = true, $values = null)
    {
        $this->nullable = $nullable;

        if ($values !== null) {
            $this->nullValues($values);
        }

        return $this;
    }

    /**
     * Specify nullable values.
     *
     * @param  array|Closure  $values
     * @return $this
     */
    public function nullValues($values)
    {
        return $this->withMeta(['nullValues' => $values]);

        return $this;
    }

    /**
     * @param mixed $value
     * @param bool $assert
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate($value, bool $assert = false)
    {
        $validator = static::validator(
            [$this->name => $value],
            [$this]
        );

        if ($assert) {
            $validator->validate();
        }

        return !$validator->fails();
    }

    /**
     * @param array $input
     * @param Field[] $fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $input, array $fields): IValidator
    {
        $rules = collect($fields)
            ->values()
            ->reduce(function ($acc, Field $field) {
                $acc[$field->name] = implode('|', $field->getRules());
                return $acc;
            }, []);

        return Validator::make($input, $rules);
    }

    /**
     * @param array $input
     * @param Field[] $fields
     * @param bool $validated return only validated inputs
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateInput(array $input, array $fields, bool $validated = false)
    {
        $validator = static::validator($input, $fields);
        $validator->validate();
        return $validated ? $validator->validated() : $input;
    }

    /**
     * Get local fields.
     * Gives child classes a changes to add extra fields
     *
     * @return array
     */
    public function getLocalFields(): array
    {
        $localFields = $this->localFields;
        if (count($this->extraLocalFields)) {
            $localFields = array_merge($localFields, $this->extraLocalFields);
        }

        return $localFields;
    }

    /**
     * Get rules and include addition rules based on the field properties.
     *
     * @return string[]
     */
    public function getRules(): array
    {
        $rules = $this->rules;

        if ($this->required) $rules[] = 'required';
        if ($this->nullable) $rules[] = 'nullable';

        return $rules;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $key = Str::camel($key);
        if (array_key_exists($key, $this->meta)) {
            return Arr::get($this->meta, $key);
        }
    }

    /**
     * The the array value.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->getLocalFields() as $field) {
            $array[$field] = $this->$field;
        }

        return array_merge($array, $this->meta());
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
