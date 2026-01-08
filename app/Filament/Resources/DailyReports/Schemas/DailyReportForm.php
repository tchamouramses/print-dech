<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use App\Models\DailyReport;
use App\Models\MoveType;
use App\Models\PointOfSale;
use App\Utils\Utils;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DailyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        $pointOfSales = Utils::pointOfSales();
        return $schema
            ->components([
                Select::make('point_of_sale_id')
                    ->label("Point de vente")
                    ->options($pointOfSales->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->default($pointOfSales->first()?->id)
                    ->disabled($pointOfSales->count() === 1)
                    ->live()
                    ->required(),
                Select::make('move_type_id')
                    ->label("Type")
                    ->options(MoveType::pluck('name', 'id')->toArray())
                    ->options(function (Get $get): array {
                        $existingMoveTypeIds = DailyReport::whereYear('day', today()->year)
                            ->whereMonth('day', today()->month)
                            ->whereDay('day', today()->day)
                            ->where('point_of_sale_id', $get('point_of_sale_id'))
                            ->pluck('move_type_id');
                        return MoveType::whereNotIn('id', $existingMoveTypeIds)->pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('amount')
                    ->label("Montant")
                    ->required()
                    ->numeric(),
                DateTimePicker::make('day')
                    ->label("Date")
                    ->default(now())
                    ->required(),
                TextInput::make('commission_amount')
                    ->label("Montant commission")
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('tip_amount')
                    ->label("Montant pourboire")
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
