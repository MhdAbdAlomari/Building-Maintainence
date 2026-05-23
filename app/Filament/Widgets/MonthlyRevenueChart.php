<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue';
    protected static ?string $description = 'Total paid revenue (SYP) over the last 12 months';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $start = now()->startOfMonth()->subMonths(11);

        $rows = Payment::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(amount_usd_cents) as total")
            ->where('status', 'paid')
            ->where('created_at', '>=', $start)
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $labels = [];
        $data   = [];
        for ($i = 0; $i < 12; $i++) {
            $month    = $start->copy()->addMonths($i);
            $labels[] = $month->format('M Y');
            $data[]   = (int) ($rows[$month->format('Y-m')] ?? 0);
        }

        // Light-to-dark green gradient across the 12 bars (#46A55E → #17662F)
        $bars = [];
        for ($i = 0; $i < 12; $i++) {
            $t = $i / 11;
            $r = (int) round(70 + (23 - 70) * $t);
            $g = (int) round(165 + (102 - 165) * $t);
            $b = (int) round(94 + (47 - 94) * $t);
            $bars[] = sprintf('#%02X%02X%02X', $r, $g, $b);
        }

        return [
            'datasets' => [[
                'label'                => 'Revenue (SYP)',
                'data'                 => $data,
                'backgroundColor'      => $bars,
                'borderColor'          => '#17662F',
                'borderWidth'          => 1,
                'borderRadius'         => 6,
                'hoverBackgroundColor' => '#46A55E',
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
