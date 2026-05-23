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

        // ShamFix brand palette — spec order
        $palette = [
            '#309949', // brand green
            '#3B82F6', // blue
            '#F59E0B', // amber
            '#8B5CF6', // violet
            '#EC4899', // pink
            '#EF4444', // red
            '#6B7280', // gray
            '#14B8A6', // teal
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
