<?php

use MOIREI\Fields\Inputs\Field;
use MOIREI\Fields\Inputs\Text;


it('should set field name', function () {
    $fieldA = Text::make('Field A');
    $fieldB = Text::make('Field B', 'a_second_field');

    expect($fieldA->name)->toEqual('field_a');
    expect($fieldB->name)->toEqual('a_second_field');
});

it('should fill extra fields', function () {
    $field = new class("Field A") extends Field
    {
        protected array $extraLocalFields = ['extra'];
        public $extra = 1;
    };

    $field->fill([
        'extra' => 3,
    ]);

    expect($field->name)->toEqual('field_a');
    expect($field->extra)->toEqual(3);
});

it('should cast array', function () {
    $field = new class("Test field") extends Field
    {
        protected array $extraLocalFields = ['extra'];
        public $extra = 1;
    };

    $field->fill([
        'extra' => 3,
    ]);

    $array = $field->toArray();

    expect(array_keys($array))->toContain('extra');
    expect($array['label'])->toEqual('Test field');
    expect($array['extra'])->toEqual(3);
});
