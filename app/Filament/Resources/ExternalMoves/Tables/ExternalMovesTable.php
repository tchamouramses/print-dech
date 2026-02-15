<?php

namespace App\Filament\Resources\ExternalMoves\Tables;

use App\Models\Client;
use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\Enums\UserRoleEnum;
use App\Models\ExternalMove;
use App\Models\User;
use App\Utils\Utils;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExternalMovesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(ExternalMove::query()->latest())
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
                    ->options(Utils::pointOfSales()->pluck('name', 'id')->toArray()),
                SelectFilter::make('client_id')
                    ->label("Client")
                    ->searchable()
                    ->visible(auth()->user()->isAdmin())
                    ->options(Client::pluck('name', 'id')->toArray()),
                Filter::make('date')
                    ->schema([
                        DatePicker::make('start_date')->label("Periode debut"),
                        DatePicker::make('end_date')->label("Periode Fin"),
                    ])
                    ->query(fn ($query, $data) =>
                        $query->when(isset($data['start_date']), function ($query) use ($data) {
                            $query->whereDate('date', '>=', $data['start_date']);
                        })->when(isset($data['end_date']), function ($query) use ($data) {
                                $query->whereDate('date', '<=', $data['end_date']);
                        })
                    )
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
