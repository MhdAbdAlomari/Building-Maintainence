<?php

namespace App\Filament\Widgets;

use App\Models\Request as WorkRequest;
use App\Models\Region;
use App\Models\Service;
use App\Models\TechnicianDetail;
use App\Models\Payment;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class MyAssets extends Widget
{
    protected static string $view = 'filament.widgets.my-assets';
    protected int|string|array $columnSpan = 1;

    protected function getViewData(): array
    {
        $requestsCount    = WorkRequest::count();
        $techniciansCount = TechnicianDetail::count();
        $servicesCount    = Service::count();
        $regionsCount     = Region::count();

        $pendingCount    = WorkRequest::where('status', 'pending')->count();
        $inProgressCount = WorkRequest::whereIn('status', ['accepted', 'on_the_way'])->count();
        $completedCount  = WorkRequest::where('status', 'complete')->count();

        // ✅ Payment stats
        $paidCount = WorkRequest::where('is_paid', true)->count();

        $unpaidCompletedCount = WorkRequest::where('status', 'complete')
            ->where('is_paid', false)
            ->count();

        $revenueUsd = Payment::where('status', 'paid')
            ->sum(DB::raw('amount_usd_cents / 100'));

        $topServiceRow = WorkRequest::select('service_id', DB::raw('COUNT(*) as c'))
            ->whereNotNull('service_id')
            ->groupBy('service_id')
            ->orderByDesc('c')
            ->first();

        $topRegionRow = WorkRequest::query()
            ->select('addresses.region_id', DB::raw('COUNT(*) as c'))
            ->join('addresses', 'addresses.id', '=', 'requests.address_id')
            ->whereNotNull('addresses.region_id')
            ->groupBy('addresses.region_id')
            ->orderByDesc('c')
            ->first();

        $topServiceName = $topServiceRow ? Service::find($topServiceRow->service_id)?->name : null;

        $topRegionName = null;
        if ($topRegionRow) {
            $topRegionName = Region::where('id', $topRegionRow->region_id)->value('name');
        }

        return [
            'requestsCount'    => $requestsCount,
            'techniciansCount' => $techniciansCount,
            'servicesCount'    => $servicesCount,
            'regionsCount'     => $regionsCount,

            'pendingCount'     => $pendingCount,
            'inProgressCount'  => $inProgressCount,
            'completedCount'   => $completedCount,

            // ✅ added
            'paidCount' => $paidCount,
            'unpaidCompletedCount' => $unpaidCompletedCount,
            'revenueUsd' => (float) $revenueUsd,

            'topServiceName'   => $topServiceName,
            'topServiceCount'  => $topServiceRow->c ?? 0,

            'topRegionName'    => $topRegionName,
            'topRegionCount'   => $topRegionRow->c ?? 0,
        ];
    }
}
