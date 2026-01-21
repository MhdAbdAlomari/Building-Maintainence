<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('address_text');
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->text('address_text', 500)->nullable()->after('description');
        });
    }
};
