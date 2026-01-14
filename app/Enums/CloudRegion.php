<?php

namespace App\Enums;

enum CloudRegion: string
{
    case US_EAST_1 = 'us-east-1';
    case US_EAST_2 = 'us-east-2';
    case CA_CENTRAL_1 = 'ca-central-1';
    case EU_CENTRAL_1 = 'eu-central-1';
    case EU_WEST_1 = 'eu-west-1';
    case EU_WEST_2 = 'eu-west-2';
    case AP_SOUTHEAST_1 = 'ap-southeast-1';
    case AP_SOUTHEAST_2 = 'ap-southeast-2';

    public function label(): string
    {
        return match ($this) {
            self::US_EAST_1 => 'US East (Virginia)',
            self::US_EAST_2 => 'US East (Ohio)',
            self::CA_CENTRAL_1 => 'CA Central (Central)',
            self::EU_CENTRAL_1 => 'EU Central (Frankfurt)',
            self::EU_WEST_1 => 'EU West (Ireland)',
            self::EU_WEST_2 => 'EU West (London)',
            self::AP_SOUTHEAST_1 => 'Asia Pacific (Singapore)',
            self::AP_SOUTHEAST_2 => 'Asia Pacific (Sydney)',
        };
    }
}
