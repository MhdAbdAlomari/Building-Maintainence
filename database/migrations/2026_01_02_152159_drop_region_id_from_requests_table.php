<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            if (Schema::hasColumn('requests', 'region_id')) {
                $table->dropConstrainedForeignId('region_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->foreignId('region_id')->constrained()->cascadeOnUpdate();
        });
    }
};
