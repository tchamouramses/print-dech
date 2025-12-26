<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardCardWidget;
use App\Filament\Widgets\LastTransactionWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 1;
    }
    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            DashboardCardWidget::class,
            LastTransactionWidget::class
        ];
    }
}
