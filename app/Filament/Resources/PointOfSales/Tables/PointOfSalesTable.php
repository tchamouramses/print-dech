<?php

namespace App\Filament\Resources\PointOfSales\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PointOfSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit(20),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('users')
                    ->tooltip('Liste des agents')
                    ->color('secondary')
                    ->iconButton()
                    ->icon(Heroicon::UserGroup)
                    ->modalHeading(fn ($record) => 'Point de vente - ' . $record->name)
                    ->modalWidth('3xl')
                    ->close(false)
                    ->modalContent(fn ($record) => view('filament.modals.restaurant-agents', [
                        'pointOfSaleId' => $record->id,
                    ]))
                    ->modalFooterActions([]),
                EditAction::make()->iconButton()
                    ->tooltip('Modifier'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
