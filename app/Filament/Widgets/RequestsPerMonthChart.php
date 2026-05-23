<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Widgets\ChartWidget;

class RequestsPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Requests Per Month';
    protected static ?string $description = 'New maintenance requests over the last 12 months';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $start = now()->startOfMonth()->subMonths(11);

        $rows = Request::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as c")
            ->where('created_at', '>=', $start)
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('c', 'ym')
            ->toArray();

        $labels = [];
        $data   = [];
        for ($i = 0; $i < 12; $i++) {
            $month    = $start->copy()->addMonths($i);
            $labels[] = $month->format('M Y');
            $data[]   = (int) ($rows[$month->format('Y-m')] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Requests',
                    'data'            => $data,
                    'borderColor'     => '#309949',
                    'backgroundColor' => 'rgba(48, 153, 73, 0.15)',
                    'borderWidth'     => 2,
                    'pointBackgroundColor' => '#309949',
                    'pointRadius'     => 4,
                    'pointHoverRadius' => 6,
                    'fill'            => true,
                    'tension'         => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                    'align'    => 'end',
                    'labels'   => [
                        'usePointStyle' => true,
                        'boxWidth'      => 8,
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['precision' => 0],
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
