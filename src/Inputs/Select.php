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
     * @param mixed $attribute
     * @param mixed $nameOperation
     * @param mixed $nameValue
     * @param bool $setRules
     * @return $this
     */
    public function options($options, string $attribute = null, $nameOperation = null, $nameValue = null, bool $setRules = false)
    {
        if (is_callable($options)) {
            $options = $options();
        }

        $options = collect($options ?? [])->map(function ($option) {
            return is_array($option) ?
                $option :
                ['text' => Str::ucfirst($option), 'value' => $option];
        })->values()->all();

        $meta = [];

        if ($attribute) {
            if (!isset($meta['conditionalOptions'])) $meta['conditionalOptions'] = [];
            $meta['conditionalOptions'][] = [
                'options' => $options,
                'attribute' => $attribute,
                'operation' => is_null($nameValue) ? '=' : (string)$nameOperation,
                'value' => is_null($nameValue) ? $nameOperation : $nameValue,
            ];
        } else {
            $meta['options'] = $options;
        }

        if ($setRules) {
            $this->rulesFromOptions();
        }

        return $this->withMeta($meta);
    }

    /**
     * Set rules from options.
     * Not implemented for conditionalOptions
     *
     * @return $this
     */
    public function rulesFromOptions()
    {
        if ($options = Arr::get($this->meta, 'options')) {
            $this->rules(Rule::in(array_map(fn ($option) => $option['value'], $options)));
        } else if ($conditionalOptions = Arr::get($this->meta, 'conditionalOptions')) {
            // foreach ($conditionalOptions as $option) {
            //     $attribute = $option['attribute'];
            //     $operation = $option['operation'];
            //     $this->rules(Rule::in(array_map(fn ($option) => $option['value'], $this->options)));
            // }
        }

        return $this;
    }
}
