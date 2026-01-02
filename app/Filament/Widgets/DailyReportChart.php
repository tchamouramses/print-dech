<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\PointOfSale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DailyReportChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected ?string $heading = 'Mouvements internes par type';
    protected ?string $pollingInterval = '20s';
    protected string $color = 'primary';
    protected bool $isCollapsible = true;
    protected ?string $maxHeight = '600px';
    protected function getData(): array
    {
        $date = $this->pageFilters['date'] ?? today()->format('Y-m-d');
        $pointOfSaleId = $this->pageFilters['point_of_sale_id'] ?? PointOfSale::query()->first()?->id;
        $baseQuery = Bilan::where('point_of_sale_id', $pointOfSaleId);

        $trend = Trend::query((clone $baseQuery))
            ->between(Carbon::parse($date)->startOfDay(), Carbon::parse($date)->endOfDay())
            ->dateColumn('date')
            ->perHour();

        $labels = (clone $trend)->count()->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d M'));

        $datasets = [
                [
                    'label' => "Ecart",
                    'data' => (clone $trend)->sum('daily_gap_amount')->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'danger',
                    'fill' => true,
                    'tension' => 0,
                ],
                [
                    'label' => "Solde de caisse globale",
                    'data' => (clone $trend)->sum('daily_report_amount')->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'secondary',
                    'fill' => true,
                    'tension' => 0,
                ],
            ];

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return !auth()->user()->isAgent();
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "XAF " + value.toLocaleString(); }',
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }

}
