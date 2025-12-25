<?php

namespace App\Filament\Resources\ExternalMoves\Pages;

use App\Filament\Resources\ExternalMoves\ExternalMoveResource;
use App\Filament\Widgets\ExternalMoveAmountWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExternalMoves extends ListRecords
{
    protected static string $resource = ExternalMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ExternalMoveAmountWidget::class,
        ];
    }
}
