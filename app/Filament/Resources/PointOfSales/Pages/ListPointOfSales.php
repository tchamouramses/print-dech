<?php

namespace App\Filament\Resources\PointOfSales\Pages;

use App\Filament\Resources\PointOfSales\PointOfSaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPointOfSales extends ListRecords
{
    protected static string $resource = PointOfSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
