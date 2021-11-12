<?php

namespace MOIREI\Fields;

use Illuminate\Support\Arr;

/**
 * The meta field on the implementing model must be casted to array
 */
trait HasFieldMeta
{
    /**
     * Set additional meta information for the element.
     *
     * @param  array  $meta
     * @return $this
     */
    public function withMeta(array $meta)
    {
        $this->meta = array_merge($this->meta ?: [], $meta);

        return $this;
    }

    /**
     * Get items attribute
     *
     * @return array
     */
    public function getOptionsAttribute(): array
    {
        return Arr::get($this->meta, 'options', []);
    }

    /**
     * Set options attribute
     *
     * @param array $options
     * @return array
     */
    public function setOptionsAttribute(array $options): array
    {
        $this->withMeta(['options' => $options]);
        return $options;
    }

    /**
     * Get min attribute
     * For number inputs, slider and range-slider
     *
     * @return int|null
     */
    public function getMinAttribute(): int|null
    {
        return Arr::get($this->meta, 'min', 0);
    }

    /**
     * Set min attribute
     * For number inputs, slider and range-slider
     *
     * @param int|float $min
     * @return int|null
     */
    public function setMinAttribute(int|float $min = 0): int|null
    {
        $this->withMeta(['min' => $min]);
        return $min;
    }

    /**
     * Get max attribute
     * For number inputs, slider and range-slider
     *
     * @return int|null
     */
    public function getMaxAttribute(): int|null
    {
        return Arr::get($this->meta, 'min', 100);
    }

    /**
     * Set max attribute
     * For number inputs, slider and range-slider
     *
     * @param int|float $max
     * @return int|null
     */
    public function setMaxAttribute(int|float $max): int|null
    {
        $this->withMeta(['max' => $max]);
        return $max;
    }

    /**
     * Get false_value attribute
     * For select, switch and radio
     *
     * @return mixed
     */
    public function getFalseValueAttribute()
    {
        return Arr::get($this->meta, 'falseValue', false);
    }

    /**
     * Set false_value attribute
     * For number select, switch and radio
     *
     * @param mixed $falsy
     * @return mixed
     */
    public function setFalseValueAttribute($falseValue)
    {
        $this->withMeta(['falseValue' => $falseValue]);
        return $falseValue;
    }

    /**
     * Get true_value attribute
     * For select, switch and radio
     *
     * @return mixed
     */
    public function getTrueValueAttribute()
    {
        return Arr::get($this->meta, 'trueValue', true);
    }

    /**
     * Set true_value attribute
     * For number select, switch and radio
     *
     * @param mixed $truthy
     * @return mixed
     */
    public function setTrueValueAttribute($trueValue)
    {
        $this->withMeta(['trueValue' => $trueValue]);
        return $trueValue;
    }

    /**
     * Get step attribute
     *
     * @return mixed
     */
    public function getStepAttribute(): int|float
    {
        return Arr::get($this->meta, 'step', 1);
    }

    /**
     * Set step attribute
     *
     * @param int|float $step
     * @return int|float
     */
    public function setStepAttribute(int|float $step): int|float
    {
        $this->withMeta(['step' => $step]);
        return $step;
    }

    /**
     * Get the field conditions
     *
     * @return array
     */
    public function getConditionsAttribute(): array
    {
        return Arr::get($this->meta, 'conditions', []);
    }

    /**
     * Set field conditions
     *
     * @param array $conditions
     * @return array
     */
    public function setConditionsAttribute(array $conditions): array
    {
        $this->withMeta(['conditions' => $conditions]);
        return $conditions;
    }

    /**
     * Get the field condition options
     *
     * @return array
     */
    public function getConditionOptionsAttribute(): array
    {
        return Arr::get($this->meta, 'conditionOptions', []);
    }

    /**
     * Set field conditions
     *
     * @param array $conditions
     * @return array
     */
    public function setConditionOptionsAttribute(array $conditionOptions): array
    {
        $this->withMeta(['conditionOptions' => $conditionOptions]);
        return $conditionOptions;
    }

    /**
     * Get the multiple option attribute
     *
     * @return bool
     */
    public function getMultipleAttribute(): bool
    {
        return Arr::get($this->meta, 'multiple', false);
    }

    /**
     * Set the multiple option attribute
     *
     * @param bool $multiple
     * @return bool
     */
    public function setMultipleAttribute(bool $multiple): bool
    {
        $this->withMeta(['multiple' => $multiple]);
        return $multiple;
    }

    /**
     * Get the integer option attribute
     *
     * @return bool
     */
    public function getIntegerAttribute(): bool
    {
        return Arr::get($this->meta, 'integer', false);
    }

    /**
     * Set the integer option attribute
     *
     * @param bool $integer
     * @return bool
     */
    public function setIntegerAttribute(bool $integer): bool
    {
        $this->withMeta(['integer' => $integer]);
        return $integer;
    }

    /**
     * Get the rows option attribute
     *
     * @return int
     */
    public function getRowsAttribute(): int
    {
        return Arr::get($this->meta, 'rows', 5);
    }

    /**
     * Set the rows option attribute
     *
     * @param int $rows
     * @return int
     */
    public function setRowsAttribute(int $rows): int
    {
        $this->withMeta(['rows' => $rows]);
        return $rows;
    }

    /**
     * Get the hint option attribute
     *
     * @return string
     */
    public function getHintAttribute(): string|null
    {
        return Arr::get($this->meta, 'hint');
    }

    /**
     * Set the hint option attribute
     *
     * @param string|null $hint
     * @return string|null
     */
    public function setHintAttribute(string|null $hint): string|null
    {
        $this->withMeta(['hint' => $hint]);
        return $hint;
    }

    /**
     * Get the persistentHint option attribute
     *
     * @return string
     */
    public function getPersistentHintAttribute(): bool
    {
        return Arr::get($this->meta, 'persistentHint', false);
    }

    /**
     * Set the persistentHint option attribute
     *
     * @param bool $persistentHint
     * @return bool
     */
    public function setPersistentHintAttribute(bool $persistentHint): bool
    {
        $this->withMeta(['persistentHint' => $persistentHint]);
        return $persistentHint;
    }

    /**
     * Get the persistent hint option attribute
     *
     * @return bool
     */
    public function getAsHtmlAttribute(): bool
    {
        return Arr::get($this->meta, 'asHtml', false);
    }

    /**
     * Set the asHtml option attribute
     *
     * @param bool $asHtml
     * @return bool
     */
    public function setAsHtmlAttribute(bool $asHtml): bool
    {
        $this->withMeta(['asHtml' => $asHtml]);
        return $asHtml;
    }

    /**
     * Get the creationRules option attribute
     *
     * @return array
     */
    public function getCreationRulesAttribute(): array
    {
        return Arr::get($this->meta, 'creationRules', []);
    }

    /**
     * Set the creationRules option attribute
     *
     * @param array $creationRules
     * @return array
     */
    public function setCreationRulesAttribute(array $creationRules): array
    {
        $this->withMeta(['creationRules' => $creationRules]);
        return $creationRules;
    }

    /**
     * Get the updateRules option attribute
     *
     * @return array
     */
    public function getUpdateRulesAttribute(): array
    {
        return Arr::get($this->meta, 'updateRules', []);
    }

    /**
     * Set the updateRules option attribute
     *
     * @param array $updateRules
     * @return array
     */
    public function setUpdateRulesAttribute(array $updateRules): array
    {
        $this->withMeta(['updateRules' => $updateRules]);
        return $updateRules;
    }

    /**
     * Get the number option attribute
     *
     * @return bool
     */
    public function getNumberAttribute(): bool
    {
        return Arr::get($this->meta, 'number', false);
    }

    /**
     * Set the number option attribute
     *
     * @param bool $number
     * @return bool
     */
    public function setNumberAttribute(bool $number): bool
    {
        $this->withMeta(['number' => $number]);
        return $number;
    }

    /**
     * Get the null values for the field
     *
     * @return array
     */
    public function getNullValuesAttribute(): array
    {
        return Arr::get($this->meta, 'nullValues', [null, '']);
    }

    /**
     * Set the null values for the field
     *
     * @param array $nullValues
     * @return array
     */
    public function setNullValuesAttribute(array $nullValues): array
    {
        $this->withMeta(['nullValues' => $nullValues]);
        return $nullValues;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), $this->meta);
    }
}
