<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('status', [
                'pending',
                'estimate_price',
                'confirmed',
                'processing',
                'awaiting_final_approval',
                'completed',
                'rejected',
                'cancelled',
            ])->default('pending');

            $table->string('title');
            $table->text('description');
            $table->date('scheduled_date');
            $table->time('scheduled_time');

            $table->unsignedBigInteger('estimated_price')->nullable();
            $table->text('estimate_note')->nullable();

            $table->unsignedBigInteger('final_price_syp')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();

            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamp('estimated_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('processing_at')->nullable();
            $table->timestamp('final_approval_requested_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};