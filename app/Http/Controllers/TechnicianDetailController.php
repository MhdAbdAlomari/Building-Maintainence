<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTechnicianDetailRequest;
use App\Http\Resources\TechnicianDetailResource;
use App\Models\TechnicianDetail;
use Illuminate\Http\Request;

class TechnicianDetailController extends Controller
{
    public function index(Request $request)
    {
        $user=$request->user();
        $detail = TechnicianDetail::where('user_id', $user->id)->first();
        if (! $detail) {
          return $this->response(null, 'Technician detail not found', 404);
    }
        return $this->response(new TechnicianDetailResource($detail));
    }

   public function update(UpdateTechnicianDetailRequest $request)
{
    $user = $request->user();

    // لازم السجل يكون موجود (أنشأه الأدمن)
    $detail = TechnicianDetail::where('user_id', $user->id)->firstOrFail();

    $validated = $request->validated();

    $detailData = [];
    $userData = [];

    if (array_key_exists('years_of_experience', $validated)) {
        $detailData['years_of_experience'] = $validated['years_of_experience'];
    }

    if (array_key_exists('skills_description', $validated)) {
        $detailData['skills_description'] = $validated['skills_description'];
    }

    if (array_key_exists('name', $validated)) {
        $userData['name'] = $validated['name'];
    }

    if (array_key_exists('email', $validated)) {
        $userData['email'] = $validated['email'];
    }

    if (array_key_exists('phone', $validated)) {
        $userData['phone'] = $validated['phone'];
    }

    if (array_key_exists('address', $validated)) {
        $userData['address'] = $validated['address'];
    }

    if (!empty($detailData)) {
        $detail->update($detailData);
    }

    if (!empty($userData)) {
        $user->update($userData);
    }

    $detail->load('user');

    return $this->response(new TechnicianDetailResource($detail));
}
}