<?php

namespace MOIREI\Fields\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Select extends Field
{
    /**
     * @inheritdoc
     */
    public $input = 'select';

    /**
     *Allow multie selects on the field.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple(bool $multiple = true)
    {
        return $this->withMeta(['multiple' => $multiple]);
    }

    /**
     * Set the options for the select menu.
     *
     * @param  array|\Closure|\Illuminate\Support\Collection
     * @param mixed $property
     * @param mixed $nameOperation
     * @param mixed $nameValue
     * @param bool $setRules
     * @return $this
     */
    public function items($items, string $property = null, $nameOperation = null, $nameValue = null, bool $setRules = false)
    {
        if (is_callable($items)) {
            $items = $items();
        }

        $items = collect($items ?? [])->map(function ($option) {
            return is_array($option) ?
                $option :
                ['text' => Str::ucfirst($option), 'value' => $option];
        })->values()->all();

        $meta = [];

        if ($property) {
            $conditionalItems = $this->meta('conditionalItems', []);
            $conditionalItems[] = [
                'items' => $items,
                'property' => $property,
                'operation' => is_null($nameValue) ? '=' : (string)$nameOperation,
                'value' => is_null($nameValue) ? $nameOperation : $nameValue,
            ];
            $meta['conditionalItems'] = $conditionalItems;
        } else {
            $meta['items'] = $items;
        }

        if ($setRules) {
            $this->rulesFromItems();
        }

        return $this->withMeta($meta);
    }

    /**
     * Set the options for the select menu.
     *
     * @param  array|\Closure|\Illuminate\Support\Collection
     * @param mixed $property
     * @param mixed $nameOperation
     * @param mixed $nameValue
     * @param bool $setRules
     * @return $this
     */
    public function options($items, string $property = null, $nameOperation = null, $nameValue = null, bool $setRules = false)
    {
        return $this->items($items, $property, $nameOperation, $nameValue, $setRules);
    }

    /**
     * Get the select options.
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->meta('items', []);
    }

    /**
     * Get the select options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->getItems();
    }

    /**
     * Set rules from options.
     * Not implemented for conditionalItems
     *
     * @return $this
     */
    public function rulesFromItems()
    {
        if ($items = Arr::get($this->meta, 'items')) {
            $this->rules(Rule::in(array_map(fn ($option) => $option['value'], $items)));
        } else if ($conditionalItems = Arr::get($this->meta, 'conditionalItems')) {
            // foreach ($conditionalItems as $option) {
            //     $property = $option['property'];
            //     $operation = $option['operation'];
            //     $this->rules(Rule::in(array_map(fn ($option) => $option['value'], $this->items)));
            // }
        }

        return $this;
    }
}
