<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->string('province');
            $table->string('city');
            $table->string('district')->nullable();
            $table->text('address');
            $table->string('postal_code', 10);

            // ID dari RajaOngkir untuk kalkulasi
            $table->string('destination_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};