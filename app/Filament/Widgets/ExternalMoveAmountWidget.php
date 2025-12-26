<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ExternalMoves\Pages\ListExternalMoves;
use App\Models\Enums\ExternalMoveTypeEnum;
use App\Utils\Utils;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class ExternalMoveAmountWidget extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    public function getTablePage(): string
    {
        return ListExternalMoves::class;
    }

    protected function getStats(): array
    {
        $query = $this->getPageTableQuery();

        $outAmounts = (clone $query)->where('type', ExternalMoveTypeEnum::OUT->value)->pluck('amount')->toArray();
        $intAmounts = (clone $query)->where('type', ExternalMoveTypeEnum::INCOME->value)->pluck('amount')->toArray();
        $totalAmounts = (clone $query)->pluck('amount')->toArray();

        return [
            Stat::make(
                label: 'Mouvements sortants',
                value: 'XAF ' . Utils::formatAmount(array_sum($outAmounts)),
            )->description('Montant des mouvememts sortants')
                ->descriptionColor('danger')
                ->descriptionIcon('iconsax-two-money-send', IconPosition::Before)
                ->chart($outAmounts)
                ->color('danger'),

            Stat::make(
                label: 'Montant mouvement entrant',
                value: 'XAF ' . Utils::formatAmount(array_sum($intAmounts)),
            )->description('Montant des mouvememts entrants')
                ->descriptionColor('success')
                ->descriptionIcon('iconsax-two-money-recive', IconPosition::Before)
                ->chart($intAmounts)
                ->color('success'),

            Stat::make(
                label: 'Différence',
                value: 'XAF ' . Utils::formatAmount(array_sum($totalAmounts)),
            )->description('Différence entrant - sortant')
                ->descriptionColor('primary')
                ->descriptionIcon('healthicons-o-money-bag', IconPosition::Before)
                ->chart($totalAmounts)
                ->color('primary'),
        ];
    }
}
