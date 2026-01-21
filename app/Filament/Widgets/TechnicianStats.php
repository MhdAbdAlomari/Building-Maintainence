<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use App\Models\User;
use App\Models\Region;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class TechnicianStats extends BaseWidget
{
    protected ?string $heading = 'Technicians Overview';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 5;

    protected function getCards(): array
    {
        // 1) All technicians
        $allTechnicians = User::where('role', 'technician')->count();

        // 2) Active technicians
        $activeTechnicians = User::where('role', 'technician')
            ->where('is_active', true)
            ->count();

        // 3) Busy technicians (have accepted / on_the_way requests)
        $busyTechnicians = Request::whereIn('status', ['accepted', 'on_the_way'])
            ->whereNotNull('technician_id')
            ->distinct('technician_id')
            ->count('technician_id');

        // 4) Technicians by Region (Top region)
        $topRegionRow = User::select('region_id', DB::raw('COUNT(*) as c'))
            ->where('role', 'technician')
            ->whereNotNull('region_id')
            ->groupBy('region_id')
            ->orderByDesc('c')
            ->first();

        $topRegionName = $topRegionRow
            ? Region::find($topRegionRow->region_id)?->name
            : null;

        $topRegionCount = $topRegionRow->c ?? 0;

        return [
            Card::make('All Technicians', $allTechnicians)
                ->icon('heroicon-o-users')
                ->extraAttributes([
                  'style' => 'background: rgba(100,116,139,0.06); border: 1px solid rgba(100,116,139,0.18);',
    ]),

            Card::make('Active Technicians', $activeTechnicians)
                ->description('Can receive requests')
                ->icon('heroicon-o-user-group')
                ->extraAttributes([
                     'style' => 'background: rgba(34,197,94,0.06); border: 1px solid rgba(34,197,94,0.18);',
                ]),

            Card::make('Busy Technicians', $busyTechnicians)
                ->description('Have current requests')
                ->icon('heroicon-o-briefcase')
                ->extraAttributes([
                    'style' => 'background: rgba(244,63,94,0.06); border: 1px solid rgba(244,63,94,0.18);',
                ]),

            Card::make('Technicians by Region', $topRegionCount)
                ->description($topRegionName ? "Top: {$topRegionName}" : 'No region assigned')
                ->icon('heroicon-o-map')
                ->extraAttributes([
                    'style' => 'background: rgba(20,184,166,0.07); border: 1px solid rgba(20,184,166,0.20);',
                ]),

            ];
    }
    
}
