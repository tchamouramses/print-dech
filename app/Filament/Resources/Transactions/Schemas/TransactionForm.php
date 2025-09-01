<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Client')
                    ->required()
                    ->relationship('client', 'name'),
                Select::make('contact_id')
                    ->label('Numéro a utilisé')
                    ->required()
                    ->relationship('contact', 'label'),
                TextInput::make('amount')
                    ->label('Montant')
                    ->prefix('XAF')
                    ->required()
                    ->numeric(),
                TextInput::make('identifier')
                    ->label('Numéro de la Transaction')
                    ->required(),
                DateTimePicker::make('date')
                    ->label('Date de la transaction')
                    ->native(false)
                    ->default(now())
                    ->required(),
                TextInput::make('sender')
                    ->label('Commissionaire')
                    ->required(),
            ]);
    }
}
