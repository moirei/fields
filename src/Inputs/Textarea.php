<?php

namespace MOIREI\Fields\Inputs;

class Textarea extends Field
{
    /**
     * @inheritdoc
     */
    public $input = 'textarea';

    /**
     * Set the number of rows used for the textarea.
     *
     * @param  int $rows
     * @return $this
     */
    public function rows($rows)
    {
        return $this->withMeta(['rows' => $rows]);
    }

    /**
     * Get the number of rows used for the textarea.
     *
     * @return int
     */
    public function getRows()
    {
        return $this->meta('rows', 5);
    }
}
