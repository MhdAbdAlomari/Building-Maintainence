<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestRequests;
use App\Filament\Widgets\MyAssets;
use App\Filament\Widgets\QuickActions;
use App\Filament\Widgets\RequestStats;
use App\Filament\Widgets\TechnicianStats;
use App\Filament\Widgets\WelcomeAdmin;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationGroup = null;
    protected static ?string $title = 'Dashboard';

    // ✅ خلي الهيدر (Welcome) لحاله فوق
    public function getHeaderWidgets(): array
    {
        return [
            WelcomeAdmin::class,
        ];
    }

    // ✅ الهيدر عمود واحد (حتى ما يجي جنب شي)
    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    // ✅ باقي الصفحة عمودين (مثل ما بدك)
    public function getColumns(): int|array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            MyAssets::class,
            QuickActions::class,

            RequestStats::class,
            TechnicianStats::class,
            LatestRequests::class,
        ];
    }
}
