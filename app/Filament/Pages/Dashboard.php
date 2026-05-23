<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MonthlyRevenueChart;
use App\Filament\Widgets\PaymentsByMethodChart;
use App\Filament\Widgets\RequestStats;
use App\Filament\Widgets\RequestsByServiceChart;
use App\Filament\Widgets\RequestsByStatusChart;
use App\Filament\Widgets\RequestsPerMonthChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -1;
    protected static ?string $title = 'Dashboard';

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 2,
        ];
    }

    public function getWidgets(): array
    {
        return [
            RequestStats::class,
            RequestsPerMonthChart::class,
            MonthlyRevenueChart::class,
            RequestsByStatusChart::class,
            RequestsByServiceChart::class,
            PaymentsByMethodChart::class,
        ];
    }
}
