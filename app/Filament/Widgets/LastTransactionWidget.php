<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LastTransactionWidget extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Transaction::query()->latest()->take(5))
            ->columns([
                TextColumn::make('reference'),
                TextColumn::make('client.name'),
                TextColumn::make('user.name'),
                TextColumn::make('contact.phone'),
                TextColumn::make('amount')
                    ->money('XAF'),
                TextColumn::make('sender'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->paginated(false);
    }
}
