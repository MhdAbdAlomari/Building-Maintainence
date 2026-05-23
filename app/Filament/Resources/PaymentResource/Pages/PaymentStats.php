<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $cash   = (int) Payment::where('status', 'paid')->where('payment_method', 'cash')->sum('amount_usd_cents');
        $stripe = (int) Payment::where('status', 'paid')->where('payment_method', 'stripe')->sum('amount_usd_cents');
        $today  = (int) Payment::where('status', 'paid')->whereDate('created_at', today())->sum('amount_usd_cents');

        return [
            Stat::make('Total Cash', number_format($cash) . ' SYP')
                ->description('Paid via cash')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),

            Stat::make('Total Stripe', number_format($stripe) . ' SYP')
                ->description('Paid via Stripe')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary'),

            Stat::make('Total Today', number_format($today) . ' SYP')
                ->description('Paid today')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
        ];
    }
}
