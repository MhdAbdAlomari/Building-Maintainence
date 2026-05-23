<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMaxDistanceRequest;
use App\Http\Resources\AddressResource;
use App\Models\TechnicianDetail;
use Illuminate\Http\Request as HttpRequest;

class TechnicianProfileController extends Controller
{
    public function setupStatus(HttpRequest $request)
    {
        $user = $request->user();

        $detail = TechnicianDetail::where('user_id', $user->id)->first();

        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();

        $hasAddress = !is_null($defaultAddress);
        $hasMaxDistance = $detail && !is_null($detail->max_distance_km);

        return $this->response([
            'has_address' => $hasAddress,
            'has_max_distance' => $hasMaxDistance,
            'is_complete' => $hasAddress && $hasMaxDistance,
            'default_address' => $defaultAddress ? new AddressResource($defaultAddress) : null,
            'max_distance_km' => $detail?->max_distance_km,
        ]);
    }

    public function updateMaxDistance(UpdateMaxDistanceRequest $request)
    {
        $user = $request->user();

        $detail = TechnicianDetail::where('user_id', $user->id)->firstOrFail();

        $detail->update([
            'max_distance_km' => $request->validated()['max_distance_km'],
        ]);

        return $this->response([
            'max_distance_km' => $detail->max_distance_km,
        ], 'Max distance updated successfully');
    }
}
