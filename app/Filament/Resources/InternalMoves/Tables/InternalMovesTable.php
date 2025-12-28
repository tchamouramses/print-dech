<?php

namespace App\Filament\Resources\InternalMoves\Tables;

use App\Models\Enums\InternalMoveStatusEnum;
use App\Models\InternalMove;
use App\Utils\Utils;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InternalMovesTable
{
    public static function configure(Table $table): Table
    {
        $pointOfSales = Utils::pointOfSales()->pluck('id')->toArray();
        return $table
            ->query(auth()->user()->isAdmin() ?
                InternalMove::query()->latest() :
                InternalMove::query()->where(function ($query) use ($pointOfSales) {
                    $query->orWhereIn('point_sender_id', $pointOfSales)
                            ->orWhereIn('point_receiver_id', $pointOfSales);
                })->latest())
            ->columns([
                TextColumn::make('amount')
                    ->label("Montant")
                    ->sortable(),
                SelectColumn::make('status')
                    ->label("Statut")
                    ->disabled(fn ($record) =>
                        ($record->status === InternalMoveStatusEnum::RECEIVE &&
                        !auth()->user()->isAdmin()) || !auth()->user()->pointOfSales()->find($record->point_receiver_id)
                    )
                    ->options(InternalMoveStatusEnum::class),
                TextColumn::make('senderPoint.name')
                    ->label("Point d'envoie")
                    ->searchable(),
                TextColumn::make('receiverPoint.name')
                    ->label("Point de reception")
                    ->searchable(),
                TextColumn::make('moveType.name')
                    ->label("Type")
                    ->searchable(),
                TextColumn::make('sender.name')
                    ->label("Envoyeur")
                    ->visible(auth()->user()->isAdmin())
                    ->searchable(),
                TextColumn::make('receiver.name')
                    ->label("Receveur")
                    ->visible(auth()->user()->isAdmin()),
                TextColumn::make('send_date')
                    ->label("Date d'envoie")
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('received_date')
                    ->label("Date de reception")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label("Date de creation")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(InternalMoveStatusEnum::class),
                Filter::make('date')
                ->schema([
                    DatePicker::make('start_date')->label("Periode debut"),
                    DatePicker::make('end_date')->label("Periode Fin"),
                ])
                ->query(fn ($query, $data) => $query->when(isset($data['start_date']), function ($query) use ($data) {
                    $query->whereDate('created_at', '>=', $data['start_date']);
                })
                ->when(isset($data['end_date']), function ($query) use ($data) {
                    $query->whereDate('created_at', '<=', $data['end_date']);
                }))
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Details'),
                EditAction::make()
                    ->tooltip('Modifier')
                    ->iconButton(),
                DeleteAction::make()
                    ->tooltip('Supprimer')
                    ->iconButton(),
            ]);
    }
}
