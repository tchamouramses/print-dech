<?php

namespace App\Filament\Resources\ExternalMoves\Schemas;

use App\Models\Client;
use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\ExternalMove;
use App\Models\PointOfSale;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExternalMoveForm
{
    public static function configure(Schema $schema): Schema
    {
        $pointOfSales = auth()->user()->isAdmin()
            ? PointOfSale::all()
            : auth()->user()->pointOfSales()->get();
        return $schema
            ->components([
                Select::make('point_of_sale_id')
                    ->label('Point de vente')
                    ->options($pointOfSales->pluck('name', 'id')->toArray())
                    ->default($pointOfSales->first()?->id)
                    ->disabled($pointOfSales->count() === 1)
                    ->searchable()
                    ->required(),
                TextInput::make('designation')
                    ->label('Designation')
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options(ExternalMoveTypeEnum::class)
                    ->required(),
                TextInput::make('amount')
                    ->label('Montant')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('date')
                    ->label('Date du mouvement de fond')
                    ->default(now())
                    ->required(),
                Select::make('client_id')
                    ->label('Client si existant')
                    ->options(Client::pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('parent_id')
                    ->label('Parent si ce mouvement est causé par un précédent')
                    ->options(ExternalMove::pluck('designation as name', 'id')->toArray())
                    ->searchable()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
