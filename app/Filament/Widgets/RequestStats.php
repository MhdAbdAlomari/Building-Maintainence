<?php

namespace App\Filament\Widgets;

use App\Models\Commission;
use App\Models\Payment;
use App\Models\Request;
use App\Models\User;
use App\Models\Wallet;
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
        // Totals
        $tenants         = User::where('role', 'tenant')->count();
        $technicians     = User::where('role', 'technician')->count();
        $requests        = Request::count();
        $revenue         = (int) Payment::where('status', 'paid')->sum('amount_usd_cents');
        $cashTotal       = (int) Payment::where('status', 'paid')->where('payment_method', 'cash')->sum('amount_usd_cents');
        $stripeTotal     = (int) Payment::where('status', 'paid')->where('payment_method', 'stripe')->sum('amount_usd_cents');
        $walletTotal     = (int) Wallet::sum('balance');
        $pendingPayCount = Payment::where('status', 'pending')->count();
        $commissionsCollected = (int) Commission::where('status', 'collected')->sum('commission_amount');
        $outstandingDebt      = (int) Commission::where('status', 'pending_debt')->sum('commission_amount');

        // Sparkline data — last 7 days
        $tenantChart  = $this->lastDaysCounts(User::query()->where('role', 'tenant'), 7);
        $techChart    = $this->lastDaysCounts(User::query()->where('role', 'technician'), 7);
        $reqChart     = $this->lastDaysCounts(Request::query(), 7);
        $revenueChart = $this->lastDaysSums(Payment::query()->where('status', 'paid'), 7, 'amount_usd_cents');
        $cashChart    = $this->lastDaysSums(Payment::query()->where('status', 'paid')->where('payment_method', 'cash'), 7, 'amount_usd_cents');
        $stripeChart  = $this->lastDaysSums(Payment::query()->where('status', 'paid')->where('payment_method', 'stripe'), 7, 'amount_usd_cents');
        $pendingChart = $this->lastDaysCounts(Payment::query()->where('status', 'pending'), 7);

        return [
            // Row 1 — per spec
            Stat::make('Total Tenants', number_format($tenants))
                ->description('Registered tenants')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart($tenantChart),

            Stat::make('Total Technicians', number_format($technicians))
                ->description('Active technicians')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success')
                ->chart($techChart),

            Stat::make('Total Requests', number_format($requests))
                ->description('All maintenance requests')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning')
                ->chart($reqChart),

            Stat::make('Total Revenue', number_format($revenue) . ' SYP')
                ->description('From paid orders')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($revenueChart),

            // Row 2 — wallet / payment breakdown
            Stat::make('Cash Payments', number_format($cashTotal) . ' SYP')
                ->description('Paid in cash')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($cashChart),

            Stat::make('Stripe Payments', number_format($stripeTotal) . ' SYP')
                ->description('Paid via Stripe')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info')
                ->chart($stripeChart),

            Stat::make('Wallet Balance', number_format($walletTotal) . ' SYP')
                ->description('Sum of technician wallets')
                ->descriptionIcon('heroicon-m-wallet')
                ->color('purple'),

            Stat::make('Pending Payments', number_format($pendingPayCount))
                ->description('Awaiting completion')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->chart($pendingChart),

            Stat::make('Commissions Collected', number_format($commissionsCollected) . ' SYP')
                ->description('Total received')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('success'),

            Stat::make('Outstanding Debt', number_format($outstandingDebt) . ' SYP')
                ->description('Owed by technicians')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
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
