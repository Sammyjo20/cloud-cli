<?php

namespace App\Exceptions;

use Exception;

class CommandExitException extends Exception
{
    public function __construct(
        int $exitCode,
        string $message = '',
    ) {
        parent::__construct($message, $exitCode);
    }

    public function getExitCode(): int
    {
        return $this->getCode();
    }
}
