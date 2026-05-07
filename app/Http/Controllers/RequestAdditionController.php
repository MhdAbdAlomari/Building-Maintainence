<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestAdditionResource;
use App\Models\Request as WorkRequest;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;

class RequestAdditionController extends Controller
{
    /**
     * عرض إضافات طلب معيّن للفني المعيّن عليه.
     */
    public function index(Request $request, $requestId)
    {
        $user = $request->user();

        $workRequest = WorkRequest::where('id', $requestId)
            // ->where('technician_id', $user->id)
            ->with('additions')
            ->firstOrFail();

        return $this->response(RequestAdditionResource::collection($workRequest->additions));
    }

    /**
     * إرسال قائمة الإضافات وطلب موافقة العميل.
     * processing -> awaiting_final_approval
     */
    public function store(Request $request, $requestId, FirebaseNotificationService $firebase)
    {
        $user = $request->user();

        $workRequest = WorkRequest::where('id', $requestId)
            ->where('technician_id', $user->id)
            ->with('additions')
            ->firstOrFail();

        if ($workRequest->status !== 'processing') {
            return $this->response(null, 'Only processing requests can request final approval', 422);
        }

        $data = $request->validate([
            'additions' => ['required', 'array', 'min:1'],
            'additions.*.name' => ['required', 'string', 'max:191'],
            'additions.*.price_syp' => ['required', 'integer', 'min:1'],
        ]);

        $workRequest->additions()->delete();

        foreach ($data['additions'] as $addition) {
            $workRequest->additions()->create([
                'name' => $addition['name'],
                'price_syp' => $addition['price_syp'],
            ]);
        }

        $workRequest->update([
            'status' => 'awaiting_final_approval',
            'final_approval_requested_at' => now(),
        ]);
        $firebase->sendRequestStatusNotification($workRequest);

        return $this->response(
            new \App\Http\Resources\RequestResource($workRequest->fresh()->load('additions')),
            'Final approval requested successfully'
        );
    }

    /**
     * حذف إضافة واحدة إذا كان الطلب ما يزال بانتظار الموافقة.
     */
    public function destroy(Request $request, $requestId, $additionId)
    {
        $user = $request->user();

        $workRequest = WorkRequest::where('id', $requestId)
            ->where('technician_id', $user->id)
            ->with('additions')
            ->firstOrFail();

        if (!in_array($workRequest->status, ['processing', 'awaiting_final_approval'])) {
            return $this->response(null, 'Cannot modify additions in this status', 422);
        }

        $addition = $workRequest->additions()->where('id', $additionId)->firstOrFail();
        $addition->delete();

        return $this->response(null, 'Addition deleted successfully');
    }
}