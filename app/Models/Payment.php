<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    
    public function workRequest()
    {
        return $this->belongsTo(\App\Models\Request::class, 'request_id');
    }


    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}

