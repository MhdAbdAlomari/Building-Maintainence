<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
        });

        $now = now();
        DB::table('app_settings')->insert([
            ['key' => 'commission_rate',   'value' => '10',                                            'created_at' => $now, 'updated_at' => $now],
            ['key' => 'debt_ceiling',      'value' => '50000',                                         'created_at' => $now, 'updated_at' => $now],
            ['key' => 'owner_name',        'value' => 'محمد عبد الرحمن محمد خير العمري',              'created_at' => $now, 'updated_at' => $now],
            ['key' => 'owner_phone',       'value' => '0964360686',                                    'created_at' => $now, 'updated_at' => $now],
            ['key' => 'owner_governorate', 'value' => 'damascus',                                      'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
