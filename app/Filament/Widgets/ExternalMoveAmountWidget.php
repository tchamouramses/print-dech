<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ExternalMoves\Pages\ListExternalMoves;
use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\ExternalMove;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExternalMoveAmountWidget extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListExternalMoves::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Mouvements sortants',
                value: 'XAF ' . $this->getPageTableQuery()->where('type', ExternalMoveTypeEnum::OUT->value)->sum('amount'),
            )->description('Montant des mouvememts sortants')
                ->descriptionColor('danger')
                ->descriptionIcon('iconsax-two-money-send', IconPosition::Before)
                ->chart($this->getPageTableQuery()->where('type', ExternalMoveTypeEnum::OUT->value)->pluck('amount')->toArray())
                ->color('danger'),
            Stat::make(
                label: 'Montant mouvement entrant',
                value: $this->getPageTableQuery()->where('type', ExternalMoveTypeEnum::INCOME->value)->sum('amount'),
            )->description('Montant des mouvememts entrants')
                ->descriptionColor('success')
                ->descriptionIcon('iconsax-two-money-recive', IconPosition::Before)
                ->color('success'),
            Stat::make(
                label: 'Difference',
                value: $this->getPageTableQuery()->sum('amount'),
            )->description('Difference entrant - sortant')
                ->descriptionColor('primary')
                ->descriptionIcon('healthicons-o-money-bag', IconPosition::Before)
                ->color('primary'),
        ];
    }
}
