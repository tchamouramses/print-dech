<?php

namespace App\Filament\Resources\MoveTypes\Pages;

use App\Filament\Resources\MoveTypes\MoveTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMoveTypes extends ListRecords
{
    protected static string $resource = MoveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
