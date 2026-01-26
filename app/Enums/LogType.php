<?php

namespace App\Enums;

enum LogType: string
{
    case ACCESS = 'access';
    case APPLICATION = 'application';
    case EXCEPTION = 'exception';
    case SYSTEM = 'system';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
