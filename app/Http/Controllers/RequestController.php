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
      $user = $request->user();           // المستخدم الحالي (tenant)
      $data=$request->validated();
      $address = $user->addresses()->findOrFail($data['address_id']);
      $data['region_id'] = $address->region_id;
      $item= $request->user()->createdRequests()->create($data);//tenant_idلضمان لا أحد يستطيع ان يمرر ال 
      $item->refresh();
      return $this->response(new RequestResource($item,'success', 201));
      }

      public function update(UpdateRequestForm $request, $id)
    {
        $user = $request->user();
        $data = $request->validated();

        $item = $user->createdRequests()->findOrFail($id);

        $address = $user->addresses()->findOrFail($data['address_id']);
        $data['region_id'] = $address->region_id;

        $item->update($data);
        

        return $this->response(new RequestResource($item));
    }
    public function destroy(HttpRequest $request,$id) 
    {
        $item = $request->user()->createdRequests()->findOrFail($id);
        $item->delete();
        return $this->response(null, 'The request has been deleted');
    }

}

