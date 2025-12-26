<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestRequests;
use App\Filament\Widgets\RequestStats;
use App\Filament\Widgets\TechnicianStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{


    // أيقونة الـ Dashboard في القائمة الجانبية
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // النص اللي يظهر في المينيو
    protected static ?string $navigationLabel = 'Dashboard';

    // مهم: خليه null أو احذف الخاصية حتى يختفي عنوان المجموعة "لوحة التحكم"
    protected static ?string $navigationGroup = null;

    // لو حابب تغيّر عنوان الصفحة فوق
    protected static ?string $title = 'Dashboard';
    public function getWidgets(): array
{
    return [
        RequestStats::class,
        TechnicianStats::class,
        LatestRequests::class,
    ];
}

    // ما نحتاج نحدد الودجات هنا بما أننا حطيناها في AdminPanelProvider
    // إذا حبيت تتحكم في ترتيبهم من هنا بدل الـ Provider، نقدر نعملها لاحقاً.
    
}

