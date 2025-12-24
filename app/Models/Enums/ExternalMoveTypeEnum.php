<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExternalMoveTypeEnum: string implements HasLabel
{
    case OUT = 'out';
    case INCOME = 'income';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OUT => "Sortie d'argent",
            self::INCOME => "Entree d'argent",
        };
    }
}
