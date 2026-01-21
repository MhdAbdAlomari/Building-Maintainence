<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Models\Request as WorkRequest;           // موديل الطلبات
use Illuminate\Http\Request as HttpRequest;      // طلب HTTP

class TechnicianRequestController extends Controller
{
    /**
     * قائمة طلبات الفني المعيّنة له.
     */
    public function index(HttpRequest $request)
    {
        $tech = $request->user();

        $items = WorkRequest::query()
            ->where('status', 'pending')
            // إذا بدك فقط الطلبات غير المسندة لفني:
            ->whereNull('technician_id')
            // (اختياري) فلترة حسب منطقة الفني إذا عندك region_id على user:
           // ->when($tech->region_id, fn ($q) => $q->where('region_id', $tech->region_id))
           // ->latest()
            ->get();

        return $this->response(RequestResource::collection($items));
    }
   
    public function show(HttpRequest $request, $id)
{
    $user = $request->user();

    $item = WorkRequest::where('id', $id)
        ->where('technician_id', $user->id) // لازم يكون مسند له
        ->firstOrFail();

    return $this->response(new RequestResource($item));
}


    /**
     * فني يقبل طلب "pending" وغير مُعيَّن لفني آخر.
     * استدعاء: PATCH /api/technician/requests/{id}/accept
     */
    public function accept(HttpRequest $request, $id)
    {
        $user = $request->user();

        // 1) جب الطلب أولًا (بدون فلترة حالة مسبقة)
        $item = WorkRequest::where('id', $id)->firstOrFail();

        // 2) حالات منتهية
        if (in_array($item->status, ['complete', 'canceled'])) {
            return $this->response(null, 'Request already finished/canceled', 422);
        }

        // 3) لو الطلب مُعيَّن
        if (!is_null($item->technician_id)) {

            // مُعيَّن لنفس الفني
            if ((int) $item->technician_id === (int) $user->id) {
                if ($item->status === 'accepted') {
                    return $this->response(new RequestResource($item), 'Already accepted', 200);
                }
                return $this->response(null, 'Cannot accept from current status', 422);
            }

            // مُعيَّن لفني آخر
            return $this->response(null, 'Already assigned to another technician', 409);
        }

        // 4) الطلب مفتوح: لازم يكون pending
        if ($item->status !== 'pending') {
            return $this->response(null, 'Only pending requests can be accepted', 422);
        }

        // (اختياري) التحقق من التخصص
        // if ($user->technicianDetails?->service_id !== $item->service_id) {
        //     return $this->response(null, 'Not your specialization', 403);
        // }

        // 5) اقبل وعيّن الفني
        $item->update([
            'technician_id' => $user->id,
            'status'        => 'accepted',
        ]);

        return $this->response(new RequestResource($item->fresh()));
    }

    /**
     * الفني يعلن أنه "بالطريق".
     * استدعاء: PATCH /api/technician/requests/{id}/on-the-way
     */
    public function onTheWay(HttpRequest $request, $id)
    {
        $user = $request->user();

        // جب الطلب بدون فلترة حالة
        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id) // أضمن أني الفني المعيّن
            ->firstOrFail();

        // حالات نهائية
        if (in_array($item->status, ['complete', 'canceled'])) {
            return $this->response(null, 'Request finished/canceled', 422);
        }

        // لو هو أصلًا on_the_way
        if ($item->status === 'on_the_way') {
            return $this->response(new RequestResource($item), 'Already on the way', 200);
        }

        // ما بصير أنتقل لـ on_the_way إلا من accepted
        if ($item->status !== 'accepted') {
            return $this->response(null, 'Cannot go on-the-way from this status', 422);
        }

        $item->update(['status' => 'on_the_way']);

        return $this->response(new RequestResource($item->fresh()));
    }

    /**
     * الفني يعلّم الطلب كمكتمل.
     * استدعاء: PATCH /api/technician/requests/{id}/complete
     */
    public function complete(HttpRequest $request, $id)
    {
        $user = $request->user();

        // جب الطلب بدون فلترة حالة
        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id) // أضمن أني الفني المعيّن
            ->firstOrFail();

        // حالات نهائية
        if ($item->status === 'canceled') {
            return $this->response(null, 'Request was canceled', 422);
        }
        if ($item->status === 'complete') {
            return $this->response(new RequestResource($item), 'Already completed', 200);
        }

        // لازم أكمله فقط من accepted أو on_the_way
        if (!in_array($item->status, ['accepted', 'on_the_way'])) {
            return $this->response(null, 'Cannot complete from this status', 422);
        }

        $data = $request->validate([
        'final_price_syp' => ['required','integer','min:1'],
    ]);

    // (اختياري) منع تغيير بعد الدفع
        if ($item->is_paid) {
            return $this->response(null, 'Already paid', 422);
        }

        $item->update([
            'final_price_syp' => $data['final_price_syp'],
            'status' => 'complete',
        ]);

    return $this->response(new RequestResource($item->fresh()));
}
   }       

