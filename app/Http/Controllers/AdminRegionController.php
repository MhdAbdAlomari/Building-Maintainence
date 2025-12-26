<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Resources\RegionResource;
use App\Models\Region;

class AdminRegionController extends Controller
{
    // GET /api/admin/regions
    public function index()
    {
        $items = Region::latest()->get();

        return $this->response(RegionResource::collection($items));
    }

    // POST /api/admin/regions
    public function store(StoreRegionRequest $request)
    {
        $item = Region::create($request->validated());

        return $this->response(
            new RegionResource($item),
            'Region has been created',
            201
        );
    }

    // GET /api/admin/regions/{id}
    public function show($id)
    {
        $item = Region::findOrFail($id);

        return $this->response(new RegionResource($item));
    }

    // PATCH /api/admin/regions/{id}
    public function update(UpdateRegionRequest $request, $id)
    {
        $item = Region::findOrFail($id);
        $item->update($request->validated());

        return $this->response(new RegionResource($item), 'Region has been updated');
    }

    // DELETE /api/admin/regions/{id}
    public function destroy($id)
    {
        $item = Region::findOrFail($id);
        $item->delete();

        return $this->response(null, 'Region has been deleted', 200);
    }
}
