<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeAdmin extends Widget
{
    protected static string $view = 'filament.widgets.welcome-admin';

    // خليها سطر كامل فوق
    protected int|string|array $columnSpan = 'full';

    // خليها أول وحدة بالداشبورد
    protected static ?int $sort = 0;
}
