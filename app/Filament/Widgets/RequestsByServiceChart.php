<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use App\Models\Service;
use Filament\Widgets\ChartWidget;

class RequestsByServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Requests by Service';
    protected static ?string $description = 'Share of requests for each maintenance service';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $services = Service::orderBy('name')->get(['id', 'name']);

        $counts = Request::query()
            ->selectRaw('service_id, COUNT(*) as c')
            ->whereNotNull('service_id')
            ->groupBy('service_id')
            ->pluck('c', 'service_id')
            ->toArray();

        $palette = [
            '#2563eb', // blue
            '#10b981', // emerald
            '#f59e0b', // amber
            '#a855f7', // violet
            '#ef4444', // red
            '#06b6d4', // cyan
            '#ec4899', // pink
            '#84cc16', // lime
            '#f97316', // orange
            '#6366f1', // indigo
        ];

        $labels = [];
        $data   = [];
        $bg     = [];
        foreach ($services as $i => $service) {
            $labels[] = $service->name;
            $data[]   = (int) ($counts[$service->id] ?? 0);
            $bg[]     = $palette[$i % count($palette)];
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
        return 'pie';
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
            'maintainAspectRatio' => false,
        ];
    }
}
