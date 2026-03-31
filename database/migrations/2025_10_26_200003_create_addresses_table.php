<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('addresses', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('region_id')->nullable()->constrained()->nullOnDelete();

        $table->string('label')->nullable();          // Home / Work
        $table->string('address_text')->nullable();   // وصف
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);

        $table->boolean('is_default')->default(false);
        $table->softDeletes();
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
