<?php

namespace App\Enums;

enum TimelineSymbol: string
{
    case DOT = '•';
    case LINE = "\e[2m│\e[22m";
    case PENDING = '◆';
    case SUCCESS = '✔';
    case FAILURE = '✘';
    case WARNING = '⚠';
    case CIRCLE = '●';

    public static function color(self $symbol): string
    {
        return match ($symbol) {
            self::DOT, self::CIRCLE => 'cyan',
            self::LINE => 'gray',
            self::PENDING, self::WARNING => 'yellow',
            self::SUCCESS => 'green',
            self::FAILURE => 'red',
        };
    }
}
