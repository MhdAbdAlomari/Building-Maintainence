<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestForm;
use App\Http\Requests\UpdateRequestForm;
use App\Http\Resources\RequestResource;
use App\Models\Request as WorkRequest;
use Illuminate\Http\Request as HttpRequest; 
class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
         $items = $request->user()             // يتطلب توكن صالح
            ->createdRequests()
            ->latest()
            ->get();
        return $this->response(RequestResource::collection($items));
    }
    
    public function show(HttpRequest $request, $id)
    {
        $item = $request->user()->createdRequests()->findOrFail($id);
        return $this->response(new RequestResource($item));
        
    }


    public function store(StoreRequestForm $request)
{
    $item = $request->user()->createdRequests()->create($request->validated());
    $item->refresh();

    return $this->response(new RequestResource($item), 'success', 201);
}

      public function update(UpdateRequestForm $request, $id)
{
    $item = $request->user()->createdRequests()->findOrFail($id);
    $item->update($request->validated());

    return $this->response(new RequestResource($item));
}

    public function destroy(HttpRequest $request,$id) 
    {
        $item = $request->user()->createdRequests()->findOrFail($id);
        $item->delete();
        return $this->response(null, 'The request has been deleted');
    }


    public function confirmEstimate(HttpRequest $request, $id)
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

    return $this->response(new RequestResource($item->fresh()));
}

    public function rejectEstimate(HttpRequest $request, $id)
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

        return $this->response(new RequestResource($item->fresh()));
    }
    

  public function approveFinalPrice(HttpRequest $request, $id)
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
    ]);

    return $this->response(new RequestResource($item->fresh()->load('additions')));
}

public function rejectFinalPrice(HttpRequest $request, $id)
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
    ]);

    return $this->response(new RequestResource($item->fresh()));
}
}