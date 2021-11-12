<?php

namespace MOIREI\Fields\Inputs;

class Text extends Field
{
    /**
     * @inheritdoc
     */
    public $input = 'text';

    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     */
    public function asHtml()
    {
        return $this->withMeta(['asHtml' => true]);
    }
}
