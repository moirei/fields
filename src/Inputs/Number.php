<?php

namespace MOIREI\Fields\Inputs;

class Number extends Text
{
    /**
     * @inheritdoc
     */
    public function __construct($label, $name = null)
    {
        parent::__construct($label, $name);
        $this->withMeta(['type' => 'number']);
    }

    /**
     * Make an interger type.
     *
     * @param  bool  $integer
     * @return $this
     */
    public function integer(bool $integer = true)
    {
        return $this->withMeta(['integer' => $integer]);
    }

    /**
     * The minimum value that can be assigned to the field.
     *
     * @param  mixed  $min
     * @return $this
     */
    public function min($min)
    {
        return $this->withMeta(['min' => $min]);
    }

    /**
     * The maximum value that can be assigned to the field.
     *
     * @param  mixed  $max
     * @return $this
     */
    public function max($max)
    {
        return $this->withMeta(['max' => $max]);
    }

    /**
     * The step size the field will increment and decrement by.
     *
     * @param  mixed  $step
     * @return $this
     */
    public function step($step)
    {
        return $this->withMeta(['step' => $step]);
    }

    /**
     * @inheritdoc
     */
    public function getRules(): array
    {
        $rules = parent::getRules();

        if (!is_null($min = $this->meta('min'))) $rules[] = 'min:' . $min;
        if (!is_null($max = $this->meta('max'))) $rules[] = 'max:' . $max;
        if ($this->meta('integer')) $rules[] = 'int';

        return $rules;
    }
}
