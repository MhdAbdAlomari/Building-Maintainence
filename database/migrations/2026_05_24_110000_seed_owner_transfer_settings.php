<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $defaults = [
            'owner_name'        => 'محمد عبد الرحمن محمد خير العمري',
            'owner_phone'       => '0964360686',
            'owner_governorate' => 'damascus',
        ];

        foreach ($defaults as $key => $value) {
            $exists = DB::table('app_settings')->where('key', $key)->exists();
            if (!$exists) {
                DB::table('app_settings')->insert([
                    'key'        => $key,
                    'value'      => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('app_settings')
            ->whereIn('key', ['owner_name', 'owner_phone', 'owner_governorate'])
            ->delete();
    }
};
