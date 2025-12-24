<?php

namespace App\Filament\Resources\PointOfSales\Pages;

use App\Filament\Resources\PointOfSales\PointOfSaleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPointOfSale extends EditRecord
{
    protected static string $resource = PointOfSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
