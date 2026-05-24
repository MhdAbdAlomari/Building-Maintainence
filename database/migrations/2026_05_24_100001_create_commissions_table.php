<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained('requests')
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('payment_id')
                ->constrained('payments')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('request_amount');
            $table->unsignedInteger('commission_rate');
            $table->unsignedBigInteger('commission_amount');

            $table->enum('payment_method', ['cash', 'stripe']);
            $table->enum('status', ['collected', 'pending_debt']);

            $table->timestamp('collected_at')->nullable();

            $table->timestamps();

            $table->index(['technician_id', 'status']);
            $table->index('status');
            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
