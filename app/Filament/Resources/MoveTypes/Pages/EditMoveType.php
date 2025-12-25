<?php

namespace App\Filament\Resources\MoveTypes\Pages;

use App\Filament\Resources\MoveTypes\MoveTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMoveType extends EditRecord
{
    protected static string $resource = MoveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
