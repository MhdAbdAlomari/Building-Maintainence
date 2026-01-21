<?php

// database/migrations/xxxx_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained('requests')
                ->cascadeOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('amount_usd_cents'); // Stripe يحتاج cents
            $table->string('currency', 3)->default('usd');

            $table->enum('status', ['pending','paid','failed','canceled'])->default('pending');

            $table->string('stripe_session_id')->nullable()->index();
            $table->string('stripe_payment_intent_id')->nullable();

            $table->timestamps();

            $table->index(['request_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

