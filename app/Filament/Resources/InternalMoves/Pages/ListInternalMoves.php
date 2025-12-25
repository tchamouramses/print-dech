<?php

namespace App\Filament\Resources\InternalMoves\Pages;

use App\Filament\Resources\InternalMoves\InternalMoveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalMoves extends ListRecords
{
    protected static string $resource = InternalMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
