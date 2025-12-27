<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InternalMoves\Pages\ListInternalMoves;
use App\Models\MoveType;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InternalMoveChart extends ChartWidget
{
    use InteractsWithPageTable;
    protected ?string $heading = 'Mouvements internes par type';
    protected ?string $pollingInterval = '20s';
    protected string $color = 'info';
    public ?string $filter = 'today';
    protected bool $isCollapsible = true;

    protected array $colors = [
        '#3B82F6', // Blue
        '#10B981', // Green
        '#F59E0B', // Amber
        '#EF4444', // Red
        '#8B5CF6', // Purple
        '#EC4899', // Pink
        '#06B6D4', // Cyan
        '#84CC16', // Lime
        '#F97316', // Orange
        '#6366F1', // Indigo
    ];

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        [$start, $end, $period] = $this->getDateRange($activeFilter);
        $moveTypes = MoveType::all();

        $trendData = Trend::query(
            (clone $this->getPageTableQuery())
        )
            ->between(start: $start, end: $end)
            ->dateColumn('send_date')
            ->{$period}()
            ->count();

        $labels = $trendData->map(fn (TrendValue $value) => $this->formatDate($value->date, $period));

        // Créer un dataset pour chaque type de mouvement
        $datasets = [];

        foreach ($moveTypes as $index => $moveType) {
            $data = Trend::query(
                (clone $this->getPageTableQuery())->where('move_type_id', $moveType->id)
            )
                ->between(start: $start, end: $end)
                ->dateColumn('send_date')
                ->{$period}()
                ->sum('amount');

            $values = $data->map(fn (TrendValue $value) => $value->aggregate);

            $color = $this->colors[$index % count($this->colors)];

            $datasets[] = [
                'label' => $moveType->name,
                'data' => $values,
                'borderColor' => $color,
                'backgroundColor' => $color . '20',
                'fill' => false,
                'tension' => 0.4,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => "Aujourd'hui",
            'week' => 'Cette semaine',
            'month' => 'Ce mois',
            'year' => 'Cette année',
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
    protected function getDateRange(string $filter): array
    {
        return match ($filter) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
                'perHour',
            ],
            'week' => [
                now()->startOfWeek(),
                now()->endOfWeek(),
                'perDay',
            ],
            'year' => [
                now()->startOfYear(),
                now()->endOfYear(),
                'perMonth',
            ],
            default => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                'perDay',
            ],
        };
    }

    protected function formatDate(string $date, string $period): string
    {
        $carbon = Carbon::parse($date);

        return match ($period) {
            'perHour' => $carbon->format('H:00'),
            'perDay' => $carbon->format('d M'),
            'perMonth' => $carbon->format('M Y'),
            default => $carbon->format('d M Y'),
        };
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
