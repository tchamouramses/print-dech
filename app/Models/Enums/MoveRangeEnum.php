<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasLabel;

enum MoveRangeEnum: string implements HasLabel
{
    case GLOBAL = 'global';
    case INTERNAL = 'internal';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GLOBAL => 'Globale',
            self::INTERNAL => 'Mouvements Interne',
        };
    }
}
