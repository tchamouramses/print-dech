<?php

namespace App\Filament\Resources\ExternalMoves\Pages;

use App\Filament\Resources\ExternalMoves\ExternalMoveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExternalMove extends EditRecord
{
    protected static string $resource = ExternalMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
