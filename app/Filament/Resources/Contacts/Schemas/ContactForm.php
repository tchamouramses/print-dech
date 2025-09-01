<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Models\Enums\ContactOperatorEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->label('Nom de la Sim')
                    ->required(),
                TextInput::make('phone')
                    ->label('Numéro de Téléphone')
                    ->tel()
                    ->required(),
                Select::make('operateur')
                    ->label('Opérateur Mobile')
                    ->required()
                    ->columnSpanFull()
                    ->options(ContactOperatorEnum::class),
            ]);
    }
}
