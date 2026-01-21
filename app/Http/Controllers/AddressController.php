<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressForm;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressForm;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index(HttpRequest $request)
    {
        $items = $request->user()
            ->addresses()
            ->with('region')
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return $this->response(AddressResource::collection($items));
    }

    public function show(HttpRequest $request, $id)
    {
        $item = $request->user()
            ->addresses()
            ->with('region')
            ->findOrFail($id);

        return $this->response(new AddressResource($item));
    }

    public function store(StoreAddressRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $item = DB::transaction(function () use ($user, $data) {
            // إذا بدو يكون default: صفّر باقي العناوين
            if (!empty($data['is_default']) && $data['is_default']) {
                $user->addresses()->update(['is_default' => false]);
            } else {
                // إذا ما عنده default أصلاً: خلي أول عنوان default تلقائي
                $hasDefault = $user->addresses()->where('is_default', true)->exists();
                if (!$hasDefault) {
                    $data['is_default'] = true;
                }
            }

            return $user->addresses()->create($data);
        });

        $item->load('region');

        return $this->response(new AddressResource($item), 'success', 201);
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $user = $request->user();
        $data = $request->validated();

        $item = $user->addresses()->findOrFail($id);

        DB::transaction(function () use ($user, $item, $data) {
            if (array_key_exists('is_default', $data) && $data['is_default']) {
                $user->addresses()->update(['is_default' => false]);
            }

            $item->update($data);
        });

        $item->load('region');

        return $this->response(new AddressResource($item));
    }

    public function destroy(HttpRequest $request, $id)
    {
        $user = $request->user();
        $item = $user->addresses()->findOrFail($id);

        $wasDefault = (bool) $item->is_default;

        DB::transaction(function () use ($user, $item, $wasDefault) {
            $item->delete();

            // إذا حذف default: خلي أحدث عنوان يصير default
            if ($wasDefault) {
                $newDefault = $user->addresses()->latest()->first();
                if ($newDefault) {
                    $newDefault->update(['is_default' => true]);
                }
            }
        });

        return $this->response(null, 'The address has been deleted');
    }}