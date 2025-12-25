<?php

namespace App\Filament\Resources\InternalMoves\Pages;

use App\Filament\Resources\InternalMoves\InternalMoveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternalMove extends EditRecord
{
    protected static string $resource = InternalMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
