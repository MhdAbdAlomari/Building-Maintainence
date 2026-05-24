<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
    }

    public static function getCommissionRate(): int
    {
        return (int) static::get('commission_rate', 10);
    }

    public static function getDebtCeiling(): int
    {
        return (int) static::get('debt_ceiling', 50000);
    }
}
