<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardTechnicianResource;
use App\Http\Resources\RequestResource;
use App\Models\Request as WorkRequest;
use App\Models\TechnicianDetail;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

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
        $user = $request->user();

        if ($user->isDebtBlocked()) {
            return $this->response([], 'You have outstanding dues. Please settle your balance to receive new requests.');
        }

        $detail = TechnicianDetail::where('user_id', $user->id)->first();

        if (!$detail) {
            return $this->response([], 'Technician profile not found. Please contact admin.', 422);
        }

        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();

        if (!$defaultAddress) {
            return $this->response([], 'Please set a default address to see available requests');
        }

        if (is_null($detail->max_distance_km)) {
            return $this->response([], 'Please set your max distance to see available requests');
        }

        $techLat = $defaultAddress->latitude;
        $techLng = $defaultAddress->longitude;
        $maxDistance = $detail->max_distance_km;
        $serviceId = $detail->service_id;

        $haversine = TechnicianDetail::haversineSQL();

        $items = WorkRequest::query()
            ->select('requests.*')
            ->selectRaw("{$haversine} AS distance_km", [$techLat, $techLng, $techLat])
            ->join('addresses', 'requests.address_id', '=', 'addresses.id')
            ->where('requests.status', 'pending')
            ->whereNull('requests.technician_id')
            ->whereNotNull('requests.address_id')
            ->where('requests.service_id', $serviceId)
            ->whereRaw("{$haversine} <= ?", [$techLat, $techLng, $techLat, $maxDistance])
            ->orderBy('distance_km', 'asc')
            ->with(['media', 'address'])
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
            ->where('technician_id', $user->id)
            ->firstOrFail();

        return $this->response(new RequestResource($item));
    }

    public function getByStatus(HttpRequest $request, $status)
    {
        $allowedStatuses = [
            'pending',
            'estimate_price',
            'confirmed',
            'processing',
            'awaiting_final_approval',
            'completed',
            'cancelled',
            'rejected',
        ];

        if (!in_array($status, $allowedStatuses)) {
            return $this->response([], 'Invalid status value', 422);
        }

        if ($status === 'pending') {
            return $this->getPendingRequests($request);
        }

        $items = WorkRequest::query()
            ->where('status', $status)
            ->where('technician_id', Auth::id())
            ->latest()
            ->with(['media', 'tenant', 'address'])
            ->get();

        return $this->response(RequestResource::collection($items));
    }

    private function getPendingRequests(HttpRequest $request)
    {
        $user = $request->user();

        if ($user->isDebtBlocked()) {
            return $this->response([], 'You have outstanding dues. Please settle your balance to receive new requests.');
        }

        $detail = TechnicianDetail::where('user_id', $user->id)->first();

        if (!$detail) {
            return $this->response([], 'Technician profile not found. Please contact admin.', 422);
        }

        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();

        if (!$defaultAddress) {
            return $this->response([], 'Please set a default address to see available requests');
        }

        if (is_null($detail->max_distance_km)) {
            return $this->response([], 'Please set your max distance to see available requests');
        }

        $techLat = $defaultAddress->latitude;
        $techLng = $defaultAddress->longitude;
        $maxDistance = $detail->max_distance_km;
        $serviceId = $detail->service_id;

        $haversine = TechnicianDetail::haversineSQL();

        $items = WorkRequest::query()
            ->select('requests.*')
            ->selectRaw("{$haversine} AS distance_km", [$techLat, $techLng, $techLat])
            ->join('addresses', 'requests.address_id', '=', 'addresses.id')
            ->where('requests.status', 'pending')
            ->whereNull('requests.technician_id')
            ->whereNotNull('requests.address_id')
            ->where('requests.service_id', $serviceId)
            ->whereRaw("{$haversine} <= ?", [$techLat, $techLng, $techLat, $maxDistance])
            ->orderBy('distance_km', 'asc')
            ->with(['media', 'tenant', 'address'])
            ->get();

        return $this->response(RequestResource::collection($items));
    }

    

    /**
     * الفني يرسل السعر التقديري ويستلم الطلب.
     * الانتقال:
     * pending -> estimate_price
     */
    public function sendEstimate(HttpRequest $request, $id, FirebaseNotificationService $firebase)
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
        $firebase->sendRequestStatusNotification($item);

        return $this->response(new RequestResource($item->fresh()));
    }

    /**
     * الفني يبدأ التنفيذ.
     * الانتقال:
     * confirmed -> processing
     */
    public function startProcessing(HttpRequest $request, $id, FirebaseNotificationService $firebase)
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
        $firebase->sendRequestStatusNotification($item);
        return $this->response(new RequestResource($item->fresh()));
    }

    
   

    /**
     * إنهاء الطلب بعد اكتمال الصيانة.
     * لا يُسمح هنا بإرسال سعر أعلى من التقديري
     * إلا إذا كانت الموافقة قد تمت مسبقًا أثناء processing.
     */
    
    public function submitFinalPrice(HttpRequest $request, $id, FirebaseNotificationService $firebase)
    {
        $user = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('technician_id', $user->id)
            ->with('additions')
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

        $allowedMax = (int) ($item->estimated_price ?? 0) + (int) $item->additions->sum('price_syp');

        if ($allowedMax > 0 && (int) $data['final_price_syp'] > $allowedMax) {
            return $this->response(null, 'Final price cannot exceed approved total price', 422);
        }

        $item->update([
            'final_price_syp' => $data['final_price_syp'],
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        $firebase->sendRequestStatusNotification($item);
        return $this->response(new RequestResource($item->fresh()->load('additions')));
    }
   public function dashboardCount(HttpRequest $request)
{
    $technician = $request->user();

    $statuses = [
        'estimate_price',
        'confirmed',
        'processing',
        'awaiting_final_approval',
        'completed',
        'rejected',
        'cancelled',
    ];

    $counts = WorkRequest::selectRaw('status, COUNT(*) as total')
        ->where('technician_id', $technician->id)
        ->whereIn('status', $statuses)
        ->groupBy('status')
        ->pluck('total', 'status');

    $data = [
        'pending' => WorkRequest::where('status', 'pending')
            ->whereNull('technician_id')
            ->count(),
    ];

    foreach ($statuses as $status) {
        $data[$status] = $counts[$status] ?? 0;//هنا يتم المرور على كل حالة داخل المصفوفة 
                                               //ثم يتم وضع العدد واذا لم تكن هناك عدد يتم وضع صفر
    }

    return $this->response($data, 'success');
}
}