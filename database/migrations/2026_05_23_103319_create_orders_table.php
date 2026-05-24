<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->string('order_number')->unique(); // NOCTRA-20240101-XXXX
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            $table->string('courier')->nullable();        // JNE, TIKI, POS
            $table->string('courier_service')->nullable(); // REG, OKE, YES
            $table->integer('shipping_days')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'shipped',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};