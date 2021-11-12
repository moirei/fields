<?php

namespace MOIREI\Fields\Inputs;

use Illuminate\Support\Arr;

class Boolean extends Field
{
    /**
     * @inheritdoc
     */
    public $input = 'boolean';

    /**
     * @inheritdoc
     */
    public $rules = ['boolean'];

    /**
     * Specify the values to store for the field.
     *
     * @param  mixed  $trueValue
     * @param  mixed  $falseValue
     * @return $this
     */
    public function values($trueValue, $falseValue)
    {
        return $this->trueValue($trueValue)->falseValue($falseValue);
    }

    /**
     * Specify the value to store when the field is "true".
     *
     * @param  mixed  $value
     * @return $this
     */
    public function trueValue($value)
    {
        return $this->withMeta(['trueValue' => $value]);
    }

    /**
     * Specify the value to store when the field is "false".
     *
     * @param  mixed  $value
     * @return $this
     */
    public function falseValue($value)
    {
        return $this->withMeta(['falseValue' => $value]);
    }

    /**
     * Get the true value.
     *
     * @return mixed
     */
    public function getTrueValue()
    {
        return Arr::get($this->meta, 'trueValue', true);
    }

    /**
     * Get the false value.
     *
     * @return mixed
     */
    public function getFalseValue()
    {
        return Arr::get($this->meta, 'falseValue', false);
    }
}
