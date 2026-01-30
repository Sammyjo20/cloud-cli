<?php

namespace App\Prompts;

use Laravel\Prompts\Prompt;

class Answered extends Prompt
{
    public function __construct(public string $label, public string $answer, public ?string $info = null)
    {
        //
    }

    public function display(): void
    {
        $this->state = 'submit';
        $this->render();
    }

    public function value(): string
    {
        return $this->answer;
    }
}
