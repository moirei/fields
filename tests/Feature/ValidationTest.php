<?php

use MOIREI\Fields\Inputs\Field;
use MOIREI\Fields\Inputs\{Text, Number, Select, Radio, Textarea};

beforeEach(function () {
    $this->fields = [
        Text::make('Whats your name?', 'name')
            ->rules('max:24')
            ->required()
            ->placeholder('John Doe'),

        Number::make('How old are you?', 'age')
            ->integer()
            ->min(18),

        Select::make('Gender')
            ->options([
                'Fridge',
                'Bridge',
                ['text' => 'I prefer not to say', 'value' => 'other'],
            ])
            ->default('other'),

        Radio::make('Can keep you data for future promos?', 'subscribe')
            ->trueValue('Yes plez')
            ->falseValue('No thanks'),

        Textarea::make('More about yourself?', 'more')
            ->rows(10)
            ->hint('In a few words. Feel free to elaborate on the above.')
            ->persistentHint(),
    ];
});

it('should throw for invalid value', function () {
    Number::make('How old are you?', 'age')
        ->min(18)
        ->integer()
        ->validate(10, true);
})->throws(\Illuminate\Validation\ValidationException::class);

it('should throw for required value', function () {
    $data = [];
    Field::validateInput($data, $this->fields, true);
})->throws(\Illuminate\Validation\ValidationException::class);

it('should validate inputs', function () {
    $data = [
        'name' => 'James Franco',
        'age' => 50,
    ];

    $input = Field::validateInput($data, $this->fields, true);

    expect($input)->toHaveCount(2);
});
