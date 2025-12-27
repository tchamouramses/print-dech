<?php

namespace App\Filament\Resources\MoveTypes\Schemas;

use App\Models\Enums\MoveRangeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MoveTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Select::make('range')
                    ->label('Portée')
                    ->required()
                    ->options(MoveRangeEnum::class),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
