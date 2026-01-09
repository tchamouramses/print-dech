<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Utils\Utils;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class TransactionDashboardCard extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = Carbon::parse($this->pageFilters['start_date'] ?? today()->format('Y-m-d'))->startOfDay();
        $endDate = Carbon::parse($this->pageFilters['end_date'] ?? today()->format('Y-m-d'))->endOfDay();
        $pointOfSaleIds = $this->pageFilters['point_of_sale_ids'];

        $bilans = Bilan::whereBetween('date', [$startDate, $endDate])
            ->whereIn('point_of_sale_id', $pointOfSaleIds)
            ->get();

        $oldsBilanQuery = Bilan::where('date', '<=', $endDate)
            ->whereIn('point_of_sale_id', $pointOfSaleIds);
        return [
            Stat::make(
                label: 'Ecart',
                value: Utils::formatAmount($bilans->sum('daily_gap_amount')),
            )->description('Montant ecart entre le bilan du jour et le precedent bilan')
                ->chart((clone $oldsBilanQuery)->pluck('daily_gap_amount')->toArray())
                ->color(($bilans->sum('daily_gap_amount')) < 0 ? 'danger' : 'success'),
            Stat::make(
                label: 'Montant commission',
                value: Utils::formatAmount($bilans->sum('daily_commission_amount')),
            )->description('Montant total de commission')
                ->chart((clone $oldsBilanQuery)->pluck('daily_commission_amount')->toArray())
                ->color('primary'),
            Stat::make(
                label: 'Montant total',
                value: Utils::formatAmount($bilans->sum('daily_report_amount')),
            )->description('Montant total caisse')
                ->chart((clone $oldsBilanQuery)->pluck('daily_report_amount')->toArray())
                ->color('primary'),
        ];
    }
}
