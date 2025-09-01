<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Enums\UserRoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->label('Rôle')
                    ->options(UserRoleEnum::class)
                    ->default(UserRoleEnum::USER->value)
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->visibleOn(Operation::Create)
                    ->required(),
            ]);
    }
}
