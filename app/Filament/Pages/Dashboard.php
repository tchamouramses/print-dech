<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DailyReportChart;
use App\Filament\Widgets\DashboardCardWidget;
use App\Filament\Widgets\LastTransactionWidget;
use App\Filament\Widgets\ListDailyReportTable;
use App\Filament\Widgets\TransactionDashboardCard;
use App\Utils\Utils;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        $pointOfSales = Utils::pointOfSales();
        return Utils::isPrint() ? $schema : $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('point_of_sale_ids')
                            ->label('Point de vente')
                            ->searchable()
                            ->placeholder('Selectionner un point de vente')
                            ->options($pointOfSales->pluck('name', 'id')->toArray())
                            ->multiple()
                            ->required(),
                        DatePicker::make('start_date')
                            ->displayFormat('d-m-Y')
                            ->label('Debut periode'),
                        DatePicker::make('end_date')
                            ->displayFormat('d-m-Y')
                            ->label('Fin periode'),
                    ])
                ->columnSpanFull()
                ->columns(auth()->user()->isAgent() ? 2 : 3),
            ]);
    }
    public function getColumns(): int | array
    {
        return 1;
    }
    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return Utils::isPrint() ? [
            DashboardCardWidget::class,
            LastTransactionWidget::class
        ] : [
            TransactionDashboardCard::class,
            ListDailyReportTable::class,
            DailyReportChart::class,
        ];
    }
}
