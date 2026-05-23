<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class PaymentsByMethodChart extends ChartWidget
{
    protected static ?string $heading = 'Cash vs Stripe — Monthly';
    protected static ?string $description = 'Paid revenue (SYP) grouped by payment method, last 12 months';
    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '340px';

    protected function getData(): array
    {
        $start = now()->startOfMonth()->subMonths(11);

        $rows = Payment::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, payment_method, SUM(amount_usd_cents) as total")
            ->where('status', 'paid')
            ->where('created_at', '>=', $start)
            ->groupBy('ym', 'payment_method')
            ->orderBy('ym')
            ->get();

        $cash   = [];
        $stripe = [];
        $labels = [];

        for ($i = 0; $i < 12; $i++) {
            $month  = $start->copy()->addMonths($i);
            $key    = $month->format('Y-m');
            $labels[] = $month->format('M Y');

            $cash[$i]   = 0;
            $stripe[$i] = 0;

            foreach ($rows as $row) {
                if ($row->ym !== $key) {
                    continue;
                }
                if ($row->payment_method === 'cash') {
                    $cash[$i] = (int) $row->total;
                } elseif ($row->payment_method === 'stripe') {
                    $stripe[$i] = (int) $row->total;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Cash',
                    'data'            => array_values($cash),
                    'backgroundColor' => '#309949',
                    'borderColor'     => '#17662F',
                    'borderWidth'     => 1,
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Stripe',
                    'data'            => array_values($stripe),
                    'backgroundColor' => '#3B82F6',
                    'borderColor'     => '#17662F',
                    'borderWidth'     => 1,
                    'borderRadius'    => 6,
                ],
            ],
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
                    'stacked' => false,
                    'grid'    => ['display' => false],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
