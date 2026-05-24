<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('restrict');

            $table->string('product_name'); // snapshot nama saat order
            $table->decimal('price', 12, 2); // snapshot harga saat order
            $table->string('size')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 12, 2); // price * quantity

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};