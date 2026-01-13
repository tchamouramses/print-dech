<?php

namespace App\Filament\Resources\DailyReports\Tables;

use App\Models\DailyReport;
use App\Models\Enums\UserRoleEnum;
use App\Models\User;
use App\Utils\Utils;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DailyReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(DailyReport::query()->latest('day'))
            ->columns([
                TextColumn::make('amount')
                    ->label("Montant")
                    ->money('XAF'),
                TextColumn::make('commission_amount')
                    ->label("Montant commission")
                    ->money('xaf')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tip_amount')
                    ->label("Montant pourboire")
                    ->money('xaf')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('pointOfSale.name')
                    ->label("Point de vente")
                    ->searchable(),
                TextColumn::make('moveType.name')
                    ->label("Type de transaction")
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label("Agent")
                    ->visible(auth()->user()->isAdmin())
                    ->searchable(),
                TextColumn::make('day')
                    ->label("Date")
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label("Date de creation")
                    ->dateTime()
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
                    ->hidden(auth()->user()->role === UserRoleEnum::USER)
                    ->searchable()
                    ->options(Utils::pointOfSales()->pluck('name', 'id')->toArray()),
                Filter::make('created_at')
                    ->label('Periode')
                    ->schema([
                        DatePicker::make('start_period')
                            ->label('Debut periode'),
                        DatePicker::make('end_period')
                            ->label('Fin periode'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['start_period'],
                                fn ($query, $date) => $query->whereDate('day', '>=', $date),
                            )
                            ->when(
                                $data['end_period'],
                                fn ($query, $date) => $query->whereDate('day', '<=', $date),
                            );
                    })
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip('Modifier')
                    ->iconButton(),
                DeleteAction::make()
                    ->tooltip('Supprimer')
                    ->iconButton(),
            ]);
    }
}
