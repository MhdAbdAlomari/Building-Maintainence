<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = ['is_active'=>'boolean'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value)) {
                    return null;
                }
                if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                    return $value;
                }
                return Storage::disk('public')->url($value);
            },
        );
    }
}
