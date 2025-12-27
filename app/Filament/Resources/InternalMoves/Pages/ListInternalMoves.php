<?php

namespace App\Filament\Resources\InternalMoves\Pages;

use App\Filament\Resources\InternalMoves\InternalMoveResource;
use App\Filament\Widgets\InternalMoveChart;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListInternalMoves extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = InternalMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InternalMoveChart::class,
        ];
    }

}
