<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Models\Request as WorkRequest;
use Illuminate\Http\Request as HttpRequest;

class TechnicianRequestController extends Controller
{
    /**
     * قائمة الطلبات المفتوحة المتاحة للفني.
     * الشرط:
     * - الحالة pending
     * - غير مسندة لأي فني
     */
    public function availableRequests(HttpRequest $request)
    {
        $items = WorkRequest::query()
            ->where('status', 'pending')
            ->whereNull('technician_id')
            ->latest()
            ->get();

        return $this->response(RequestResource::collection($items));
    }

    /**
     * عرض طلب مسند لنفس الفني فقط.
     */
    public function showAssignedRequest(HttpRequest $request, $id)
    {
        $user = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id) // أضمن أن الطلب يخص هذا الفني
            ->firstOrFail();

        return $this->response(new RequestResource($item));
    }

    /**
     * الفني يرسل السعر التقديري ويستلم الطلب.
     * الانتقال:
     * pending -> estimate_price
     */
    public function sendEstimate(HttpRequest $request, $id)
    {
        $user = $request->user();

        // جلب الطلب أولًا بدون تقييد مسبق بالحالة
        $item = WorkRequest::where('id', $id)->firstOrFail();

        // إذا كان الطلب مغلقًا فلا يمكن التعامل معه
        if (in_array($item->status, ['completed', 'cancelled', 'rejected'])) {
            return $this->response(null, 'Request already closed', 422);
        }

        // إذا كان الطلب مسندًا أصلًا
        if (!is_null($item->technician_id)) {

            // إذا كان مسندًا لنفس الفني
            if ((int) $item->technician_id === (int) $user->id) {
                // إذا كان السعر التقديري مرسلًا مسبقًا
                if ($item->status === 'estimate_price') {
                    return $this->response(new RequestResource($item), 'Estimate already sent', 200);
                }

                return $this->response(null, 'Cannot send estimate from current status', 422);
            }

            // إذا كان مسندًا لفني آخر
            return $this->response(null, 'Already assigned to another technician', 409);
        }

        // لا يُسمح بإرسال السعر إلا إذا كانت الحالة pending
        if ($item->status !== 'pending') {
            return $this->response(null, 'Only pending requests can receive an estimate', 422);
        }

        // بيانات السعر التقديري
        $data = $request->validate([
            'estimated_price' => ['required', 'integer', 'min:1'],
            'estimate_note' => ['nullable', 'string'],
        ]);

        $item->update([
            'technician_id' => $user->id,                     // إسناد الطلب لهذا الفني
            'estimated_price' => $data['estimated_price'],   // السعر التقديري
            'estimate_note' => $data['estimate_note'] ?? null,
            'status' => 'estimate_price',
            'estimated_at' => now(),
        ]);

        return $this->response(new RequestResource($item->fresh()));
    }

    /**
     * الفني يبدأ التنفيذ.
     * الانتقال:
     * confirmed -> processing
     */
    public function startProcessing(HttpRequest $request, $id)
    {
        $user = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id) // الطلب يجب أن يكون مسندًا لنفس الفني
            ->firstOrFail();

        // إذا كان الطلب مغلقًا
        if (in_array($item->status, ['completed', 'cancelled', 'rejected'])) {
            return $this->response(null, 'Request already closed', 422);
        }

        // إذا كان أصلًا في مرحلة التنفيذ
        if ($item->status === 'processing') {
            return $this->response(new RequestResource($item), 'Already processing', 200);
        }

        // لا يبدأ التنفيذ إلا بعد موافقة العميل على السعر التقديري
        if ($item->status !== 'confirmed') {
            return $this->response(null, 'Only confirmed requests can move to processing', 422);
        }

        $item->update([
            'status' => 'processing',
            'processing_at' => now(),
        ]);

        return $this->response(new RequestResource($item->fresh()));
    }

        /**
     * أثناء processing:
     * إذا ظهرت تكلفة إضافية، يرسل الفني طلب موافقة.
     * processing -> awaiting_final_approval
     */
    public function requestFinalApproval(HttpRequest $request, $id)
    {
        $user = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id)
            ->firstOrFail();

        if ($item->status !== 'processing') {
            return $this->response(null, 'Only processing requests can request final approval', 422);
        }

        $data = $request->validate([
            'requested_final_price_syp' => ['required', 'integer', 'min:1'],
            'final_approval_note' => ['required', 'string'],
        ]);

        if (!is_null($item->estimated_price) && (int) $data['requested_final_price_syp'] <= (int) $item->estimated_price) {
            return $this->response(null, 'Requested final price must be greater than estimated price', 422);
        }

        $item->update([
            'requested_final_price_syp' => $data['requested_final_price_syp'],
            'final_approval_note' => $data['final_approval_note'],
            'status' => 'awaiting_final_approval',
            'final_approval_requested_at' => now(),
        ]);

        return $this->response(new RequestResource($item->fresh()));
    }

    /**
     * إنهاء الطلب بعد اكتمال الصيانة.
     * لا يُسمح هنا بإرسال سعر أعلى من التقديري
     * إلا إذا كانت الموافقة قد تمت مسبقًا أثناء processing.
     */
    public function submitFinalPrice(HttpRequest $request, $id)
    {
        $user = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id)
            ->firstOrFail();

        if ($item->status !== 'processing') {
            return $this->response(null, 'Only processing requests can be completed', 422);
        }

        if ($item->is_paid) {
            return $this->response(null, 'Already paid', 422);
        }

        $data = $request->validate([
            'final_price_syp' => ['required', 'integer', 'min:1'],
        ]);

        if (!is_null($item->estimated_price) && (int) $data['final_price_syp'] > (int) $item->estimated_price) {
            return $this->response(null, 'Final price cannot exceed estimated price without prior approval', 422);
        }

        $item->update([
            'final_price_syp' => $data['final_price_syp'],
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return $this->response(new RequestResource($item->fresh()));
    }
}