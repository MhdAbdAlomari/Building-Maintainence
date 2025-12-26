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
    protected static ?int $sort = 2;

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
                ->sortable(),

            Tables\Columns\TextColumn::make('tenant.name')
                ->label('Tenant')
                ->searchable(),

            Tables\Columns\TextColumn::make('service.name')
                ->label('Service'),

            Tables\Columns\TextColumn::make('region.name')
                ->label('Region'),

            Tables\Columns\TextColumn::make('status')
                ->badge(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created')
                ->since(), // مثلاً "2 hours ago"
        ];
    }
}
