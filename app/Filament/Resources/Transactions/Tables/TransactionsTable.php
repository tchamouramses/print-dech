<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Caissier(ère)')
                    ->searchable(),
                TextColumn::make('contact.phone')
                    ->label('Numéro')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->prefix('XAF ')
                    ->money()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('identifier')
                    ->label('Numéro de trans')
                    ->searchable(),
                TextColumn::make('sender')
                    ->label('Commissionaire')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('client_id')
                    ->label('Client')
                    ->options(function () {
                        return \App\Models\Client::all()->pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('user_id')
                    ->label('Employé')
                    ->options(function () {
                        return \App\Models\User::all()->pluck('name', 'id')->toArray();
                    })
                    ->searchable()
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
                Action::make('print')
                    ->iconButton()
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalCancelActionLabel('Annuler')
                    ->modalSubmitActionLabel('Imprimer')
                    ->modalDescription('Voulez-vous imprimer cette facture ?')
                    ->label('Imprimer la Facture')
                    ->modalIcon('heroicon-o-printer')
                    ->action(function (\App\Models\Transaction $record) {
                        $invoiceService = new \App\Services\InvoiceService();
                        return $invoiceService->printInvoice($record);
                    })
                    ->icon('heroicon-o-printer')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->query(fn () => Transaction::latest());
    }
}
