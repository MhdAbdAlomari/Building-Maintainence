<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class AdminServiceController extends Controller
{
    // GET /api/admin/services
    public function index()
    {
        $items = Service::latest()->get();

        return $this->response(ServiceResource::collection($items));
    }

    // POST /api/admin/services
    public function store(StoreServiceRequest $request)
    {
        $item = Service::create($request->validated());

        return $this->response(
            new ServiceResource($item),
            'Service has been created',
            201
        );
    }

    // GET /api/admin/services/{id}
    public function show($id)
    {
        $item = Service::findOrFail($id);

        return $this->response(new ServiceResource($item));
    }

    // PATCH /api/admin/services/{id}
    public function update(UpdateServiceRequest $request, $id)
    {
        $item = Service::findOrFail($id);
        $item->update($request->validated());

        return $this->response(new ServiceResource($item), 'Service has been updated');
    }

    // DELETE /api/admin/services/{id}
    public function destroy($id)
    {
        $item = Service::findOrFail($id);
        $item->delete();

        return $this->response(null, 'Service has been deleted', 200);
    }
}
