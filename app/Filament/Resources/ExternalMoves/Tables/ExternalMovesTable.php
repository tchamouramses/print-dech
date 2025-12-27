<?php

namespace App\Filament\Resources\ExternalMoves\Tables;

use App\Models\Client;
use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\Enums\UserRoleEnum;
use App\Models\ExternalMove;
use App\Models\PointOfSale;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExternalMovesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(auth()->user()->isAdmin() ?
                ExternalMove::query()->latest() :
                auth()->user()->externalMoves()->getQuery()->latest())
            ->columns([
                TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (ExternalMoveTypeEnum $state): string => match ($state->value) {
                        ExternalMoveTypeEnum::INCOME->value => 'success',
                        ExternalMoveTypeEnum::OUT->value => 'danger',
                    })
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pointOfSale.name')
                    ->label('Point de vente')
                    ->searchable(),
                TextColumn::make('client.name')
                    ->searchable(),
                TextColumn::make('parent.designation')
                    ->label('Mouvement parent')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Agent')
                    ->visible(auth()->user()->isAdmin())
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date')
                    ->label('Date du mouvement')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label("Agent")
                    ->searchable()
                    ->visible(auth()->user()->isAdmin())
                    ->options(User::where('role', UserRoleEnum::POINT_OF_SALES->value)->pluck('name', 'id')->toArray()),
                SelectFilter::make('point_of_sale_id')
                    ->label("Points de vente")
                    ->searchable()
                    ->options(auth()->user()->isAdmin() ? PointOfSale::pluck('name', 'id')->toArray() : auth()->user()->pointOfSales()->get()->pluck('name', 'id')->toArray()),
                SelectFilter::make('client_id')
                    ->label("Client")
                    ->searchable()
                    ->visible(auth()->user()->isAdmin())
                    ->options(Client::pluck('name', 'id')->toArray()),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Details'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Modifier'),
                DeleteAction::make()
                    ->visible(auth()->user()->isAdmin())
                    ->iconButton()
                    ->tooltip('Supprimer')
            ]);
    }
}
