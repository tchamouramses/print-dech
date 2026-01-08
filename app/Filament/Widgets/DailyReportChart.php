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
        $startDate = Carbon::parse($this->pageFilters['start_date'] ?? today()->format('Y-m-d'))->startOfDay();
        $endDate = Carbon::parse($this->pageFilters['end_date'] ?? today()->format('Y-m-d'))->endOfDay();
        $pointOfSaleIds = $this->pageFilters['point_of_sale_ids'];
        $baseQuery = Bilan::whereIn('point_of_sale_id', $pointOfSaleIds);
        $period = $this->period($startDate, $endDate);
        $trend = Trend::query((clone $baseQuery))
            ->between($startDate, $endDate)
            ->dateColumn('date')
            ->{$period}();

        $labels = (clone $trend)->count()->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d M'));

        $datasets = [
                [
                    'label' => "Ecart",
                    'data' => (clone $trend)->sum('daily_gap_amount')->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => true,
                    'tension' => 0,
                ],
                [
                    'label' => "Solde de caisse globale",
                    'data' => (clone $trend)->sum('daily_report_amount')->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'fill' => true,
                    'tension' => 0,
                ],
            ];

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    private function period($startDate, $endDate){
        $diffInDay = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        if($diffInDay > 1 && $diffInDay <= 30){
            return 'perDay';
        } elseif ($diffInDay > 30){
            return 'perMonth';
        } else {
            return 'perHour';
        }
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
