<?php

namespace App\Filament\Resources\MoveTypes\Tables;

use App\Models\MoveType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MoveTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(MoveType::query()->latest())
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('range')
                    ->label('Portée')
                    ->badge(),
                IconColumn::make('is_positive')
                    ->label('Valeur positive')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip('Modifier')
                    ->iconButton(),
                DeleteAction::make()
                    ->tooltip('Supprimer')
                    ->iconButton(),
            ])
            ->emptyStateHeading("Aucun type de mouvement")
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
