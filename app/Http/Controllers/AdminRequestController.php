<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\Admin\AdminRequestResource as AdminAdminRequestResource;
use App\Http\Resources\AdminRequestResource;
use App\Models\Request as MaintenanceRequest;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    // GET /api/admin/requests
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['tenant', 'technician', 'service', 'region', 'media']);

        // فلترة اختيارية
        if ($status = $request->query('status')) { //فلترة حسب الحالة فقط
            $query->where('status', $status);
        }

        if ($regionId = $request->query('region_id')) { //فلترة حسب المنطقة
            $query->where('region_id', $regionId);
        }

        if ($serviceId = $request->query('service_id')) {// فلترة حسب الخدمة
            $query->where('service_id', $serviceId);
        }

        if ($technicianId = $request->query('technician_id')) {//فلترة حسب الفني المعيّن
            $query->where('technician_id', $technicianId);
        }

        $items = $query->latest()->paginate(20);

        return $this->response(AdminRequestResource::collection($items));
    }

    // GET /api/admin/requests/{id}
    public function show($id)
    {
        $item = MaintenanceRequest::with(['tenant', 'technician', 'service', 'region', 'media'])
            ->findOrFail($id);

        return $this->response(new AdminRequestResource($item));
    }

    // PATCH /api/admin/requests/{id}
    // لتغيير حالة الطلب أو تعيين فني
    public function update(UpdateAdminRequest $request, $id)
    {
        $item = MaintenanceRequest::findOrFail($id);

        $item->update($request->validated());

        return $this->response(new AdminRequestResource($item), 'Request has been updated');
    }
}
