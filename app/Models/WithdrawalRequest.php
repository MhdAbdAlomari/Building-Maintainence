<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function branchLabels(): array
    {
        return [
            'tima'    => 'تيما',
            'alharam' => 'الهرم',
            'alfouad' => 'الفؤاد',
            'dovins'  => 'دوفينز',
        ];
    }

    public static function governorateLabels(): array
    {
        return [
            'damascus' => 'دمشق',
            'aleppo'   => 'حلب',
            'latakia'  => 'اللاذقية',
            'homs'     => 'حمص',
            'hama'     => 'حماه',
            'tartus'   => 'طرطوس',
        ];
    }
}
