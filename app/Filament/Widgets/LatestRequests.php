<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestRequests extends BaseWidget
{
    protected static ?string $heading = 'Latest Requests';
    protected int|string|array $columnSpan = 'full';

    // ترتيب الويجت في الصفحة (اختياري)
    protected static ?int $sort = 6;

    protected function getTableQuery(): Builder
    {
        return Request::with(['tenant', 'service', 'region'])
            ->latest()
            ->limit(10); // آخر 10 طلبات
    }

    protected function getTableColumns(): array
{
    return [
        Tables\Columns\TextColumn::make('id')
            ->label('#')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true) // إذا بدك تخفيه افتراضياً
            ->alignCenter(),

        Tables\Columns\TextColumn::make('tenant.name')
            ->label('Tenant')
            ->searchable()
            ->limit(24)
            ->weight('medium'),

        Tables\Columns\TextColumn::make('service.name')
            ->label('Service')
            ->sortable()
            ->badge()
             ->color(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'plumbing'   => 'info',
                        'electrical' => 'warning',
                        'painting'   => 'success',
                        'hvac'       => 'danger',
                        'carpentry'  => 'gray',
                        default      => 'primary',
                    }),

        Tables\Columns\TextColumn::make('region.name')
            ->label('Region')
            ->sortable()
            ->toggleable(),

        Tables\Columns\TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->formatStateUsing(fn (string $state) => match ($state) {
                'pending'    => 'Pending',
                'accepted'   => 'Accepted',
                'on_the_way' => 'Processing',
                'complete'   => 'Done',
                'canceled'   => 'Canceled',
                default      => ucfirst(str_replace('_', ' ', $state)),
            })
            ->color(fn (string $state): string => match ($state) {
                'pending'    => 'warning',
                'accepted'   => 'info',
                'on_the_way' => 'primary',
                'complete'   => 'success',
                'canceled'   => 'danger',
                default      => 'gray',
            })
            ->alignCenter(),

        Tables\Columns\TextColumn::make('created_at')
            ->label('Created')
            ->since()
            ->color('gray')
            ->sortable()
            ->alignEnd(),
    ];
}

    
}
