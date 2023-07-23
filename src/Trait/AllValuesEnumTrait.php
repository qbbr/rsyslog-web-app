<?php

declare(strict_types=1);

namespace App\Trait;

trait AllValuesEnumTrait
{
    public static function allValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
