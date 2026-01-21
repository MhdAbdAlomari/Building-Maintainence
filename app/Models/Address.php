<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    

    public function user() { return $this->belongsTo(User::class); }
    public function region() { return $this->belongsTo(Region::class); }
    public function requests(){ return $this->hasMany(Request::class); }
}

