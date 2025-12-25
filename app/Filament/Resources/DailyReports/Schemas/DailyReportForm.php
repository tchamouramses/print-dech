<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use App\Models\MoveType;
use App\Models\PointOfSale;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DailyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label("Montant")
                    ->required()
                    ->numeric(),
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
                Select::make('point_of_sale_id')
                    ->label("Point de vente")
                    ->options(auth()->user()->isAdmin() ? PointOfSale::pluck('name', 'id')->toArray() : auth()->user()->pointOfSales()->get()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Select::make('move_type_id')
                    ->label("Type")
                    ->options(MoveType::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                DateTimePicker::make('day')
                    ->label("Date")
                    ->default(now())
                    ->required(),
            ]);
    }
}
