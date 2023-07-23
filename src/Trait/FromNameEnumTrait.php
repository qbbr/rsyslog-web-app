<?php

declare(strict_types=1);

namespace App\Trait;

trait FromNameEnumTrait
{
    public static function tryFromName(
        string $name,
    ): ?static {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
