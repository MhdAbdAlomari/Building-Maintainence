<?php

// database/migrations/xxxx_add_payment_fields_to_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('final_price_syp')->nullable()->after('status');
            $table->boolean('is_paid')->default(false)->after('final_price_syp');
            $table->timestamp('paid_at')->nullable()->after('is_paid');
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['final_price_syp','is_paid','paid_at']);
        });
    }
};

