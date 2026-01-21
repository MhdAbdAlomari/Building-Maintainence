<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    protected function casts(): array
    {
        // ضمان التعامل مع الإحداثيات كأرقام عشرية
        return [
            'latitude' => 'decimal:8', 
            'longitude' => 'decimal:8', 
        ];
    }

    public function requests()
{
    return $this->hasMany(Request::class);
}
   public function users() 
    {
        return $this->hasMany(User::class);
    }
    public function addresses()
{
    return $this->hasMany(Address::class);
}
}
