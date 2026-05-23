<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function haversineSQL(): string
    {
        return "(6371 * ACOS(LEAST(1, COS(RADIANS(?)) * COS(RADIANS(addresses.latitude)) * COS(RADIANS(addresses.longitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(addresses.latitude)))))";
    }

    public static function hasNearbyTechnician(float $lat, float $lng, int $serviceId): bool
    {
        $haversine = static::haversineSQL();

        return static::query()
            ->where('technician_details.service_id', $serviceId)
            ->whereNotNull('technician_details.max_distance_km')
            ->join('users', function ($join) {
                $join->on('technician_details.user_id', '=', 'users.id')
                    ->whereNull('users.deleted_at');
            })
            ->join('addresses', function ($join) {
                $join->on('technician_details.user_id', '=', 'addresses.user_id')
                    ->where('addresses.is_default', true)
                    ->whereNull('addresses.deleted_at');
            })
            ->whereNotNull('addresses.latitude')
            ->whereNotNull('addresses.longitude')
            ->whereRaw("{$haversine} <= technician_details.max_distance_km", [$lat, $lng, $lat])
            ->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}

