<?php

namespace App\Prompts;

use App\Enums\TimelineSymbol;

abstract class Renderer extends \Laravel\Prompts\Themes\Default\Renderer
{
    /**
     * Render the output with a blank line above and below.
     */
    public function __toString()
    {
        return str_repeat(TimelineSymbol::LINE->value.PHP_EOL, max(2 - $this->prompt->newLinesWritten(), 0))
            .$this->output
            .(in_array($this->prompt->state, ['submit', 'cancel']) ? TimelineSymbol::LINE->value.PHP_EOL : '');
    }
}
