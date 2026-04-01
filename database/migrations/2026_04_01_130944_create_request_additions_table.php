<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_additions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained('requests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name');
            $table->unsignedBigInteger('price_syp');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_additions');
    }
};