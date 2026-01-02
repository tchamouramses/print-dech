<?php

namespace App\Filament\Widgets;

use App\Models\DailyReport;
use App\Models\PointOfSale;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListDailyReportTable extends TableWidget
{
    use InteractsWithPageFilters;
    public function table(Table $table): Table
    {
        $date = $this->pageFilters['date'] ?? today()->format('Y-m-d');
        $user_id = $this->pageFilters['user_id'] ?? null;
        $pointOfSaleId = $this->pageFilters['point_of_sale_id'] ?? PointOfSale::query()->first()?->id;
        return $table
            ->query(fn () => DailyReport::whereBetween('day', [Carbon::parse($date)->startOfDay(), Carbon::parse($date)->endOfDay()])
                ->when(function (Builder $query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                ->latest()
                ->where('point_of_sale_id', $pointOfSaleId)
            )
            ->columns([
                TextColumn::make('day')
                    ->label('Journee')
                    ->dateTime('d-m-Y'),
                TextColumn::make('pointOfSale.name')
                    ->label('Point de vente')
                    ->searchable(),
                TextColumn::make('moveType.name')
                    ->label('Element de la caisse')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Agent')
                    ->hidden(auth()->user()->isAgent())
                    ->searchable(),
                TextColumn::make('commission_amount')
                    ->money('XAF')
                    ->summarize(Sum::make()->money('XAF')),
                TextColumn::make('tip_amount')
                    ->money('XAF')
                    ->summarize(Sum::make()->money('XAF')),
                TextColumn::make('amount')
                    ->money('XAF')
                    ->summarize(Sum::make()->money('XAF')),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()
                    ->visible(auth()->user()->isAdmin())
                    ->iconButton(),
            ]);
    }
}
