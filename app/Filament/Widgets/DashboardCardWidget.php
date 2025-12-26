<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardCardWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Montant Total transactions',
                value: 'XAF ' . Transaction::query()->sum('amount'),
            )->description('Montant total des transactions')
            ->descriptionColor('secondary'),
            Stat::make(
                label: 'Total transactions',
                value: Transaction::query()->count(),
            )->description('Nomre total des transactions')
            ->descriptionColor('secondary'),
            Stat::make(
                label: 'Total des clients',
                value: Client::query()->count(),
            )->description('Nomre total des clients')
            ->descriptionColor('secondary'),
        ];
    }
}
