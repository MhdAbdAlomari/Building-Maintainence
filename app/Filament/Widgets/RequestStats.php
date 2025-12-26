<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class RequestStats extends BaseWidget
{
    // العنوان اللي بيظهر فوق الويجت
    protected ?string $heading = 'Requests Overview';

    protected function getCards(): array
    {
        return [
            Card::make('All Requests', Request::count())
                ->icon('heroicon-o-rectangle-stack'),

            Card::make('Pending', Request::where('status', 'pending')->count())
                ->description('Awaiting action')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Card::make('In Progress', Request::whereIn('status', [
                    'accepted',
                    'on_the_way',
                    'process',
                ])->count())
                ->description('Technicians are working')
                ->color('info')
                ->icon('heroicon-o-bolt'),

            Card::make('Completed', Request::where('status', 'completed')->count())
                ->description('Finished successfully')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
