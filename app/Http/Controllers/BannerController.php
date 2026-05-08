<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Models\Banner;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners=Banner::where('is_active',true)
        ->orderBy('sort_order')->latest()->get();

        return $this->response(BannerResource::collection($banners),'Success');
    }
}
