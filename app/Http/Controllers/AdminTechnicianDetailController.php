<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechnicianDetailRequest;
use App\Http\Requests\UpdateAdminTechnicianRequest;
use App\Http\Resources\AdminTechnicianDetailResource;
use App\Models\TechnicianDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTechnicianDetailController extends Controller
{
    public function index()
    {
        $items = TechnicianDetail::with(['user', 'service'])->latest()->get();

        return $this->response(AdminTechnicianDetailResource::collection($items));
    }

    public function store(StoreTechnicianDetailRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // 1) إنشاء user جديد بدور technician
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'phoe'     => $data['phone'],
                'password'  => Hash::make($data['password']),
                'address'   => $data['address'] ?? null,
                'region_id' => $data['region_id'] ?? null,
                'role'      => 'technician',
                'is_active' => true, // منطقياً كل فني جديد مفعّل
            ]);

            // 2) إنشاء TechnicianDetail مرتبط بهذا الـ user
            $detail = TechnicianDetail::create([
                'user_id'             => $user->id,               // هون استخدمنا id اللي رجع من الـ DB
                'service_id'          => $data['service_id'],
                'years_of_experience' => $data['years_of_experience'] ?? null,
                'skills_description'  => $data['skills_description'] ?? null,
            ]);

            DB::commit();

            $detail->load(['user', 'service']);

            return $this->response(
                new AdminTechnicianDetailResource($detail),
                'Technician has been created successfully',
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // أو ترجع response خاص بالخطأ
        }
    }

    public function show($id)
    {
        $item = TechnicianDetail::with(['user','service'])->findOrFail($id);

        return $this->response(new AdminTechnicianDetailResource($item));
    }

    public function update(UpdateAdminTechnicianRequest $request, $id)
    {
        $item = TechnicianDetail::findOrFail($id);
        $item->update($request->validated());

        return $this->response(new AdminTechnicianDetailResource($item));
    }


    public function destroy($id)
  {
    $detail = TechnicianDetail::with('user')->findOrFail($id);

    DB::transaction(function () use ($detail) {
        // 1) نحذف سجل الفني (Soft Delete)
        $detail->delete();

        // 2) نعطّل حساب اليوزر المرتبط
        if ($detail->user) {
            $detail->user->update([
                'is_active' => false,
            ]);
        }
    });

    return $this->response(
        null,
        'The technician has been deleted',
        200
    );
}
}
