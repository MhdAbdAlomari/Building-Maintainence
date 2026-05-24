<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDebtSettlementRequest;
use App\Http\Resources\DebtSettlementResource;
use App\Models\AppSetting;
use App\Models\Commission;
use App\Models\DebtSettlement;
use Illuminate\Http\Request as HttpRequest;

class DebtSettlementController extends Controller
{
    public function debt(HttpRequest $request)
    {
        $technician = $request->user();

        $details = Commission::where('technician_id', $technician->id)
            ->where('status', 'pending_debt')
            ->latest()
            ->get()
            ->map(fn (Commission $c) => [
                'request_id'        => $c->request_id,
                'request_amount'    => (int) $c->request_amount,
                'commission_amount' => (int) $c->commission_amount,
                'commission_rate'   => (int) $c->commission_rate,
                'payment_method'    => $c->payment_method,
                'created_at'        => $c->created_at,
            ]);

        $totalDebt = (int) $details->sum('commission_amount');
        $debtCeiling = AppSetting::getDebtCeiling();
        $commissionRate = AppSetting::getCommissionRate();

        return $this->response([
            'total_debt'         => $totalDebt,
            'total_debt_label'   => number_format($totalDebt) . ' SYP',
            'debt_ceiling'       => $debtCeiling,
            'debt_ceiling_label' => number_format($debtCeiling) . ' SYP',
            'is_blocked'         => $totalDebt >= $debtCeiling,
            'commission_rate'    => $commissionRate,
            'debt_details'       => $details,
        ]);
    }

    public function store(StoreDebtSettlementRequest $request)
    {
        $technician = $request->user();

        $hasPending = DebtSettlement::where('technician_id', $technician->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return response()->json([
                'status'  => false,
                'message' => 'You already have a pending settlement request.',
                'data'    => null,
            ], 422);
        }

        $path = $request->file('receipt_image')->store('settlements', config('filesystems.default'));

        $settlement = DebtSettlement::create([
            'technician_id' => $technician->id,
            'amount'        => (int) $request->input('amount'),
            'branch'        => $request->input('branch'),
            'receipt_image' => $path,
            'note'          => $request->input('note'),
            'status'        => 'pending',
        ]);

        return $this->response(
            new DebtSettlementResource($settlement),
            'Settlement request submitted successfully',
            201
        );
    }

    public function index(HttpRequest $request)
    {
        $technician = $request->user();

        $settlements = DebtSettlement::where('technician_id', $technician->id)
            ->latest()
            ->paginate(20);

        return $this->response([
            'settlements' => DebtSettlementResource::collection($settlements),
            'pagination'  => [
                'current_page' => $settlements->currentPage(),
                'last_page'    => $settlements->lastPage(),
                'per_page'     => $settlements->perPage(),
                'total'        => $settlements->total(),
            ],
        ]);
    }

    public function destroy(HttpRequest $request, int $id)
    {
        $technician = $request->user();

        $settlement = DebtSettlement::where('id', $id)
            ->where('technician_id', $technician->id)
            ->first();

        if (!$settlement) {
            
            return response()->json([
                'status'  => false,
                'message' => 'Settlement request not found.',
                'data'    => null,
            ], 404);
        }

        if ($settlement->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'Only pending settlement requests can be cancelled.',
                'data'    => null,
            ], 422);
        }

        $settlement->delete();

        return $this->response(null, 'Settlement request cancelled successfully');
    }
}
