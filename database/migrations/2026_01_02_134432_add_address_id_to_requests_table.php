<?php

// php artisan make:migration add_address_id_to_requests_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->nullOnDelete(); // إذا انحذف العنوان ما ينحذف الطلب
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('address_id');
        });
    }
};
