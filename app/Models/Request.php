<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

   public function tenant() // الساكن الذي أنشأ الطلب
{
    return $this->belongsTo(User::class, 'tenant_id');
}

public function technician() // الفني المُعين للطلب
{
    return $this->belongsTo(User::class, 'technician_id');
}
public function service()
{
    return $this->belongsTo(Service::class);
}
public function region()
{
    return $this->belongsTo(Region::class);
}
public function media()
{
    return $this->hasMany(Media::class);
}
public function address()
{
    return $this->belongsTo(Address::class);
}
public function payments()
{
    return $this->hasMant(Payment::class);
}




}
