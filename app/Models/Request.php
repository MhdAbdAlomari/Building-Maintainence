<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'additions_approved' => 'boolean',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'estimated_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'processing_at' => 'datetime',
        'final_approval_requested_at' => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
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
        return $this->hasMany(Payment::class);
    }
    public function additions()
    {
        return $this->hasMany(RequestAddition::class);
    }
    public function getAdditionsTotalAttribute(): int
    {
        return (int) $this->additions->sum('price_syp');
    }

    public function getRequestedTotalPriceAttribute(): int
    {
        return (int) ($this->estimated_price ?? 0) + (int) $this->additions->sum('price_syp');
    }
}