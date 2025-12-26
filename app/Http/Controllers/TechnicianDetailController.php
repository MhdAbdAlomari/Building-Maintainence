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
        $detail->update($request->validated());

        return $this->response(new TechnicianDetailResource($detail));
    }
}
