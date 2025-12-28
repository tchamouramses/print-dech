<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\PointOfSale;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class TransactionDashboardCard extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $date = $this->pageFilters['date'] ?? today()->format('Y-m-d');
        $pointOfSaleId = $this->pageFilters['point_of_sale_id'] ?? PointOfSale::query()->first()?->id;
        $bilan = Bilan::where('date', Carbon::parse($date)->format('Y-m-d'))
                    ->where('point_of_sale_id', $pointOfSaleId ?? null)
                    ->first();
        $oldsBilanQuery = Bilan::where('date', '<', Carbon::parse($date)->format('Y-m-d'))
            ->where('point_of_sale_id', $pointOfSaleId ?? null);
        return [
            Stat::make(
                label: 'Ecart',
                value: 'XAF ' . ($bilan?->daily_gap_amount ?? 0),
            )->description('Montant ecart entre le bilan du jour et le precedent bilan')
                ->chart((clone $oldsBilanQuery)->pluck('daily_gap_amount')->toArray())
                ->color(($bilan?->daily_gap_amount ?? 0) > 0 ? 'danger' : 'success'),
            Stat::make(
                label: 'Montant commission',
                value: 'XAF ' . ($bilan?->daily_commission_amount ?? 0),
            )->description('Montant total de commission')
                ->chart((clone $oldsBilanQuery)->pluck('daily_commission_amount')->toArray())
                ->color('primary'),
            Stat::make(
                label: 'Montant pourboire',
                value: 'XAF ' . ($bilan?->daily_tip_amount ?? 0),
            )->description('Montant total pourboire')
                ->chart((clone $oldsBilanQuery)->pluck('daily_tip_amount')->toArray())
                ->color('primary'),
        ];
    }
}
