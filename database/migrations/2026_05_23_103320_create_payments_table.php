<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            $table->string('transaction_id')->nullable()->unique(); // dari Midtrans
            $table->string('snap_token')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'refund',
            ])->default('pending');

            $table->string('payment_type')->nullable(); // qris, bank_transfer, gopay
            $table->decimal('gross_amount', 12, 2);
            $table->json('payment_response')->nullable(); // raw response Midtrans

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};