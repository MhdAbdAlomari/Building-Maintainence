<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class RequestStats extends BaseWidget
{
    // العنوان اللي بيظهر فوق الويجت
    protected ?string $heading = 'Requests Overview';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 4;

    protected function getCards(): array
    {
        return [
             Card::make('All Requests', Request::count())
                ->icon('heroicon-o-rectangle-stack')
                ->extraAttributes([
                    'style' => 'background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.18);',
                ]),

            Card::make('Pending', Request::where('status', 'pending')->count())
                ->description('Awaiting action')
                ->color('warning')
                ->icon('heroicon-o-clock')
                ->extraAttributes([
                 'style' => 'background: rgba(245,158,11,0.07); border: 1px solid rgba(245,158,11,0.22);',
                ]),

            Card::make('In Progress', Request::whereIn('status', [
                    'accepted',
                    'on_the_way',
                    'process',
                ])->count())
                ->description('Technicians are working')
                ->color('info')
                ->icon('heroicon-o-bolt')
                 ->extraAttributes([
                    'style' => 'background: rgba(168,85,247,0.06); border: 1px solid rgba(168,85,247,0.18);',
                ]),

            Card::make('Completed', Request::where('status', 'complete')->count())
                ->description('Finished successfully')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->extraAttributes([
                    'style' => 'background: rgba(48,153,73,0.06); border: 1px solid rgba(48,153,73,0.18);',
                ]),
        ];
    }
}
