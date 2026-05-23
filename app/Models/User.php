<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   // protected $fillable = [
   //     'name',
   //     'email',
   //     'password',
   // ];
       protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
   // protected function casts(): array
    //{
      //  return [
        //    'email_verified_at' => 'datetime',
         //   'password' => 'hashed',
        //];
    //}

        /**
     * : الطلبات التي أنشأها هذا المستخدم (عندما يكون دوره ساكن ).
     */
     public function createdRequests()
    {
        return $this->hasMany(Request::class, 'tenant_id');
    }
    
    /**
     * : الطلبات التي تم تعيينها لهذا المستخدم (عندما يكون دوره فني).
     */
    public function assignedRequests()
    {
        return $this->hasMany(Request::class, 'technician_id');
    }
    public function technicianDetail()
{
    // ستبحث Laravel تلقائياً عن 'user_id' في جدول 'technician_details'
    return $this->hasOne(TechnicianDetail::class); // 
}
   public function region() 
    {
        return $this->belongsTo(Region::class);
    }
    public function canAccessPanel(Panel $panel): bool
{
   
    return $this->role === 'admin';
}
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class,'tenant_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'technician_id');
    }
}
