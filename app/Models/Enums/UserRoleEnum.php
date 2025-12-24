<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRoleEnum: string implements HasLabel
{
    case ADMIN = 'admin';
    case USER = 'user';
    case POINT_OF_SALES = 'sale_point';

    public static function toArray(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function toString(): string
    {
        return implode(',', array_column(self::cases(), 'value'));
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Super administrateur',
            self::USER => 'Agent',
            self::POINT_OF_SALES => 'Administrateur point de vente',
        };
    }
}
