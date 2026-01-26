<?php

namespace App\Enums;

enum LogLevel: string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
    case DEBUG = 'debug';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
