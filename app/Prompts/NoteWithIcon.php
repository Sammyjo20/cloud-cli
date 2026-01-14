<?php

namespace App\Prompts;

use App\Enums\TimelineSymbol;
use Laravel\Prompts\Prompt;

class NoteWithIcon extends Prompt
{
    public function __construct(public string $message, public TimelineSymbol $icon)
    {
        //
    }

    public function display(): void
    {
        $this->render();
    }

    public function value(): mixed
    {
        return null;
    }
}
