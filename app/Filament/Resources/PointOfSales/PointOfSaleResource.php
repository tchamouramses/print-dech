<?php

namespace App\Filament\Resources\PointOfSales;

use App\Filament\Resources\PointOfSales\Pages\CreatePointOfSale;
use App\Filament\Resources\PointOfSales\Pages\EditPointOfSale;
use App\Filament\Resources\PointOfSales\Pages\ListPointOfSales;
use App\Filament\Resources\PointOfSales\Schemas\PointOfSaleForm;
use App\Filament\Resources\PointOfSales\Tables\PointOfSalesTable;
use App\Models\PointOfSale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PointOfSaleResource extends Resource
{
    protected static ?string $model = PointOfSale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Point de vente';

    public static function form(Schema $schema): Schema
    {
        return PointOfSaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PointOfSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPointOfSales::route('/'),
        ];
    }
}
