<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestForm;
use App\Http\Requests\UpdateRequestForm;
use App\Http\Resources\RequestResource;
use App\Models\Request as WorkRequest;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
        $items = $request->user()             // يتطلب توكن صالح
            ->createdRequests()
            ->with(['media','tenant'])
            ->latest()
            ->get();
        return $this->response(RequestResource::collection($items));
    }

    public function show(HttpRequest $request, $id)
    {
        $item = $request->user()->createdRequests()->findOrFail($id);
        $item->refresh()->load(['media','tenant']);
        return $this->response(new RequestResource($item));
    }


    public function store(StoreRequestForm $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            //هنا يتم حذف جدول الميديا من مصفوفة البيانات والسبب انو جدول الريكويست لا يحتوي على عمو اسمو الاميجيز
            unset($data['images']);

            $item = $request->user()->createdRequests()->create($data);

            foreach ($request->file('images', []) as $image) {
                $path = $image->store("requests/{$item->id}/before", 'public');

                $item->media()->create([
                    'type' => 'before',
                    'url'  => asset(Storage::url($path)),
                ]);
            }

            DB::commit();
         //   $item->refresh()->load('user');

            $item->refresh()->load(['media','tenant']);

            return $this->response(new RequestResource($item), 'success', 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->response(null, $e->getMessage(), 500);
        }
    }

    public function update(UpdateRequestForm $request, $id)
    {
        DB::beginTransaction();

        try {
            $item = $request->user()->createdRequests()->findOrFail($id);

            $data = $request->validated();

            unset($data['images']);
            if ($item->status !== 'pending') {
                return $this->response(null, 'You can update the request only while it is pending', 422);
            }

            $item->update($data);

            if ($request->hasFile('images')) {
                $oldBeforeMedia = $item->media()
                    ->where('type', 'before')
                    ->get();

                foreach ($oldBeforeMedia as $media) {
                    $path = str_replace('/storage/', '', $media->url);

                    Storage::disk('public')->delete($path);

                    $media->delete();
                }

                foreach ($request->file('images', []) as $image) {
                    $path = $image->store("requests/{$item->id}/before", 'public');

                    $item->media()->create([
                        'type' => 'before',
                        'url'  => Storage::url($path),
                    ]);
                }
            }

            DB::commit();

            $item->refresh()->load(['media','tenant']);

            return $this->response(new RequestResource($item), 'success');
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->response(null, $e->getMessage(), 500);
        }
    }

    public function destroy(HttpRequest $request, $id)
    {
        $item = $request->user()->createdRequests()->findOrFail($id);
        $item->delete();
        return $this->response(null, 'The request has been deleted');
    }


    public function confirmEstimate(HttpRequest $request, $id, FirebaseNotificationService $firebase)
    {
        $item = $request->user()
            ->createdRequests()
            ->findOrFail($id);

        if ($item->status !== 'estimate_price') {
            return $this->response(null, 'Only estimated requests can be confirmed', 422);
        }

        $item->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        $firebase->sendRequestActionToTechnician($item);

        return $this->response(new RequestResource($item->fresh()));
    }

    public function rejectEstimate(HttpRequest $request, $id, FirebaseNotificationService $firebase)
    {
        $item = $request->user()
            ->createdRequests()
            ->findOrFail($id);

        if ($item->status !== 'estimate_price') {
            return $this->response(null, 'Only estimated requests can be rejected', 422);
        }

        $item->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        $firebase->sendRequestActionToTechnician($item);
        return $this->response(new RequestResource($item->fresh()));
    }


    public function approveFinalPrice(HttpRequest $request, $id, FirebaseNotificationService $firebase)
    {
        $item = $request->user()
            ->createdRequests()
            ->with('additions')
            ->findOrFail($id);

        if ($item->status !== 'awaiting_final_approval') {
            return $this->response(null, 'Only requests awaiting final approval can be approved', 422);
        }

        $item->update([
            'status' => 'processing',
            'additions_approved' => true,
        ]);
        $firebase->sendRequestActionToTechnician($item);
        return $this->response(new RequestResource($item->fresh()->load('additions')));
    }

    public function rejectFinalPrice(HttpRequest $request, $id, FirebaseNotificationService $firebase)
    {
        $item = $request->user()
            ->createdRequests()
            ->findOrFail($id);

        if ($item->status !== 'awaiting_final_approval') {
            return $this->response(null, 'Only requests awaiting final approval can be rejected', 422);
        }

        $item->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'Final approval rejected by tenant',
            'cancelled_at' => now(),
            'additions_approved' => false,

        ]);
        $firebase->sendRequestStatusNotification($item);

        return $this->response(new RequestResource($item->fresh()));
    }
}
