<?php

namespace App\Filament\Resources\InternalMoves\Schemas;

use App\Models\Enums\InternalMoveStatusEnum;
use App\Models\Enums\MoveRangeEnum;
use App\Models\MoveType;
use App\Models\PointOfSale;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InternalMoveForm
{
    public static function configure(Schema $schema): Schema
    {
        $pointOfSales = auth()->user()->isAdmin() ? PointOfSale::all() : auth()->user()->pointOfSales()->get();
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label("Montant")
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label("Statut")
                    ->options(InternalMoveStatusEnum::class)
                    ->default(InternalMoveStatusEnum::SEND)
                    ->disabled(true)
                    ->required(),
                Select::make('point_sender_id')
                    ->label("Point d'envoi")
                    ->required()
                    ->options($pointOfSales->pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('point_receiver_id')
                    ->label("Point de reception")
                    ->required()
                    ->options(PointOfSale::pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('move_type_id')
                    ->label("Type de transaction")
                    ->required()
                    ->options(MoveType::where('range', MoveRangeEnum::INTERNAL->value)->pluck('name', 'id')->toArray())
                    ->searchable(),
                DateTimePicker::make('send_date')
                    ->label("Date d'envoie")
                    ->default(now())
                    ->required(),
            ]);
    }
}
