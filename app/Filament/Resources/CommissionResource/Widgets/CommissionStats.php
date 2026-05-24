<?php

namespace App\Filament\Resources\CommissionResource\Widgets;

use App\Models\Commission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommissionStats extends BaseWidget
{
    protected function getStats(): array
    {
        $collected = (int) Commission::where('status', 'collected')->sum('commission_amount');
        $pending   = (int) Commission::where('status', 'pending_debt')->sum('commission_amount');

        return [
            Stat::make('Total Collected', number_format($collected) . ' SYP')
                ->description('Commissions received')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Pending Debt', number_format($pending) . ' SYP')
                ->description('Owed by technicians')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}
