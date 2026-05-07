<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
       
        $items = Service::orderBy('name')->get();

        return $this->response(ServiceResource::collection($items));
    }
}
