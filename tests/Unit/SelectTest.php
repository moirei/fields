<?php

use MOIREI\Fields\Inputs\Select;

uses()->group('select');

it('should return options', function () {
    $field = Select::make('Select field')->options(['A', 'b', 'c']);

    expect($field->getOptions())->toHaveCount(3);
});

it('should return conditional options', function () {
    $field = Select::make('Select field')
        ->options([
            ['text' => 'Kilogram (kg)', 'value' => 'kg'],
            ['text' => 'Gram (g)', 'value' => 'g'],
        ], 'unit_system', 'metric')
        ->options([
            ['text' => 'Pound (lb)', 'value' => 'lb'],
            ['text' => 'Ounce (oz)', 'value' => 'oz'],
        ], 'unit_system', 'imperial');

    $conditionalItems = $field->meta('conditionalItems');

    expect($conditionalItems)->toHaveCount(2);
    expect($conditionalItems[0]['items'])->toHaveCount(2);
});
