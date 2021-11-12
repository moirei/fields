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
