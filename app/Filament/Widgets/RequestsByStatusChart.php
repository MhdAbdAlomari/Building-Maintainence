<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Widgets\ChartWidget;

class RequestsByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Requests by Status';
    protected static ?string $description = 'Distribution of all maintenance requests by their current status';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '320px';

    protected function getData(): array
    {
        // ShamFix brand palette
        $palette = [
            'pending'                 => '#F59E0B', // amber
            'estimate_price'          => '#3B82F6', // blue
            'confirmed'               => '#8B5CF6', // violet
            'processing'              => '#14B8A6', // teal
            'awaiting_final_approval' => '#EC4899', // pink
            'completed'               => '#309949', // brand green
            'rejected'                => '#EF4444', // red
            'cancelled'               => '#6B7280', // gray
        ];

        $counts = Request::query()
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status')
            ->toArray();

        $labels = [];
        $data   = [];
        $bg     = [];
        foreach ($palette as $status => $color) {
            $labels[] = ucwords(str_replace('_', ' ', $status));
            $data[]   = (int) ($counts[$status] ?? 0);
            $bg[]     = $color;
        }

        return [
            'datasets' => [[
                'label'           => 'Requests',
                'data'            => $data,
                'backgroundColor' => $bg,
                'borderColor'     => '#ffffff',
                'borderWidth'     => 2,
                'hoverOffset'     => 8,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'right',
                    'labels'   => [
                        'usePointStyle' => true,
                        'boxWidth'      => 8,
                        'padding'       => 12,
                    ],
                ],
            ],
            'cutout' => '60%',
            'maintainAspectRatio' => false,
        ];
    }
}
