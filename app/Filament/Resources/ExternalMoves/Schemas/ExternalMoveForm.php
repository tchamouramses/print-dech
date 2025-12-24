<?php

namespace App\Filament\Resources\ExternalMoves\Schemas;

use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\ExternalMove;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExternalMoveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                Select::make('point_of_sale_id')
                    ->label('Point de vente')
                    ->options(auth()->user()->pointOfSales()->pluck('name', 'point_of_sales.id as id')->toArray())
                    ->required(),
                Select::make('client_id')
                    ->label('Client si existant')
                    ->relationship('client', 'name'),
                DateTimePicker::make('date')
                    ->label('Date du mouvement de fond')
                    ->default(now())
                    ->required(),
                Select::make('parent_id')
                    ->label('Parent si ce mouvement est causé par un précédent')
                    ->options(ExternalMove::pluck('designation as name', 'id')->toArray())
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
