<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    case User = 'user';
    case Employee = 'employee';
    case Manager = 'manager';
    case Admin = 'admin';

    public static function values(): array
    {
        return [
            self::User->value,
            self::Employee->value,
            self::Manager->value,
            self::Admin->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::User => 'User',
            self::Employee => 'Employee',
            self::Manager => 'Manager',
            self::Admin => 'Admin',
        };
    }
}
