<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasLabel;

enum InternalMoveStatusEnum: string implements HasLabel
{
    case RECEIVE = 'received';
    case SEND = 'sending';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::RECEIVE => 'Recu',
            self::SEND => 'Envoie en cours',
        };
    }
}
