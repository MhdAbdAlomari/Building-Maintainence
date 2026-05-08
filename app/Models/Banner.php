<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = ['is_active'=>'boolean'];
}
