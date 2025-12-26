<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\Request;

class TechnicianStats extends BaseWidget
{
    protected ?string $heading = 'Technicians Overview';

    protected function getCards(): array
    {
        return [
            Card::make('Active Technicians', User::where('role', 'technician')->where('is_active', true)->count())
                ->icon('heroicon-o-user-group'),

            Card::make('Busy Technicians', Request::whereIn('status', ['accepted','on_the_way','in_progress'])->distinct('technician_id')->count('technician_id'))
                ->description('Have current requests')
                ->icon('heroicon-o-briefcase'),
        ];
    }
}

