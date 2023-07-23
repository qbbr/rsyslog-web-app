<?php

declare(strict_types=1);

namespace App\Enum;

use App\Trait\AllValuesEnumTrait;
use App\Trait\FromNameEnumTrait;

enum Priority: int
{
    use AllValuesEnumTrait;
    use FromNameEnumTrait;

    case emerg = 0;
    case alert = 1;
    case crit = 2;
    case error = 3;
    case warn = 4;
    case notice = 5;
    case info = 6;
    case debug = 7;

    public function badge(): string
    {
        return match ($this) {
            self::emerg, self::alert, self::crit, self::error => 'danger',
            self::warn => 'warning',
            self::notice => 'primary',
            self::info => 'info',
            self::debug => 'dark',
        };
    }
}
