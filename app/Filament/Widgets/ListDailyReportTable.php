<?php

namespace App\Filament\Widgets;

use App\Models\DailyReport;
use App\Models\PointOfSale;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ListDailyReportTable extends TableWidget
{
    use InteractsWithPageFilters;
    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['start_date'];
        $endDate = $this->pageFilters['end_date'];
        $pointOfSaleIds = array_map(fn($pointOfSaleId): int => (int) $pointOfSaleId, $this->pageFilters['point_of_sale_ids']);

        return $table
            ->query(fn () => DailyReport::when(isset($startDate), fn ($query) => $query->where('day', '>=', Carbon::parse($startDate)->startOfDay()))
                ->when(isset($endDate), fn ($query) => $query->where('day', '<=', Carbon::parse($endDate)->endOfDay()))
                ->latest()
                ->whereIn('point_of_sale_id', $pointOfSaleIds)
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
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Agent')
                    ->placeholder('Selectionner un agent')
                    ->hidden(auth()->user()->isAgent())
                    ->searchable()
                    ->options(User::whereHas('pointOfSales', fn ($builder) => $builder->whereIn('point_of_sales.id', $pointOfSaleIds))->pluck('name', 'id')->toArray()),

                SelectFilter::make('point_of_sale_id')
                    ->label('Point de vente')
                    ->placeholder('Selectionner un point de vente')
                    ->hidden(auth()->user()->isAgent())
                    ->searchable()
                    ->options(PointOfSale::whereIn('id', $pointOfSaleIds)->pluck('name', 'id')->toArray()),
            ]);
    }
}
