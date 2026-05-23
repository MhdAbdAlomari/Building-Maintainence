<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Request;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class RequestStats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $now      = now();
        $thisFrom = $now->copy()->startOfMonth();
        $thisTo   = $now->copy()->endOfMonth();
        $lastFrom = $now->copy()->subMonth()->startOfMonth();
        $lastTo   = $now->copy()->subMonth()->endOfMonth();

        $tenants     = User::where('role', 'tenant')->count();
        $technicians = User::where('role', 'technician')->count();
        $requests    = Request::count();
        $revenue     = (int) Payment::where('status', 'paid')->sum('amount_usd_cents');

        $tenantsThis = User::where('role', 'tenant')->whereBetween('created_at', [$thisFrom, $thisTo])->count();
        $tenantsLast = User::where('role', 'tenant')->whereBetween('created_at', [$lastFrom, $lastTo])->count();

        $techThis    = User::where('role', 'technician')->whereBetween('created_at', [$thisFrom, $thisTo])->count();
        $techLast    = User::where('role', 'technician')->whereBetween('created_at', [$lastFrom, $lastTo])->count();

        $reqThis     = Request::whereBetween('created_at', [$thisFrom, $thisTo])->count();
        $reqLast     = Request::whereBetween('created_at', [$lastFrom, $lastTo])->count();

        $revenueThis = (int) Payment::where('status', 'paid')->whereBetween('created_at', [$thisFrom, $thisTo])->sum('amount_usd_cents');
        $revenueLast = (int) Payment::where('status', 'paid')->whereBetween('created_at', [$lastFrom, $lastTo])->sum('amount_usd_cents');

        $tenantChart  = $this->lastDaysCounts(User::query()->where('role', 'tenant'), 7);
        $techChart    = $this->lastDaysCounts(User::query()->where('role', 'technician'), 7);
        $reqChart     = $this->lastDaysCounts(Request::query(), 7);
        $revenueChart = $this->lastDaysSums(Payment::query()->where('status', 'paid'), 7, 'amount_usd_cents');

        return [
            Stat::make('Total Tenants', number_format($tenants))
                ->description($this->trendLabel($tenantsThis, $tenantsLast))
                ->descriptionIcon($this->trendIcon($tenantsThis, $tenantsLast))
                ->color('info')
                ->chart($tenantChart),

            Stat::make('Total Technicians', number_format($technicians))
                ->description($this->trendLabel($techThis, $techLast))
                ->descriptionIcon($this->trendIcon($techThis, $techLast))
                ->color('success')
                ->chart($techChart),

            Stat::make('Total Requests', number_format($requests))
                ->description($this->trendLabel($reqThis, $reqLast))
                ->descriptionIcon($this->trendIcon($reqThis, $reqLast))
                ->color('warning')
                ->chart($reqChart),

            Stat::make('Total Revenue', number_format($revenue) . ' SYP')
                ->description($this->trendLabel($revenueThis, $revenueLast))
                ->descriptionIcon($this->trendIcon($revenueThis, $revenueLast))
                ->color('purple')
                ->chart($revenueChart),
        ];
    }

    protected function trendLabel(int|float $current, int|float $previous): string
    {
        if ($previous == 0 && $current == 0) {
            return 'No change from last month';
        }

        if ($previous == 0) {
            return '+100% from last month';
        }

        $pct = round((($current - $previous) / $previous) * 100, 1);
        $sign = $pct >= 0 ? '+' : '';
        return "{$sign}{$pct}% from last month";
    }

    protected function trendIcon(int|float $current, int|float $previous): string
    {
        if ($previous == 0 && $current == 0) {
            return 'heroicon-m-minus';
        }
        if ($current >= $previous) {
            return 'heroicon-m-arrow-trending-up';
        }
        return 'heroicon-m-arrow-trending-down';
    }

    protected function lastDaysCounts(Builder $query, int $days): array
    {
        $out = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $out[] = (clone $query)
                ->whereDate('created_at', $day->toDateString())
                ->count();
        }
        return $out;
    }

    protected function lastDaysSums(Builder $query, int $days, string $col): array
    {
        $out = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $out[] = (int) (clone $query)
                ->whereDate('created_at', $day->toDateString())
                ->sum($col);
        }
        return $out;
    }
}
