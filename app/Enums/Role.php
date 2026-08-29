<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Pedagang = 'pedagang';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Pedagang => 'Pedagang Pasar',
        };
    }
}
