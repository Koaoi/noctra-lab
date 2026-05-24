<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('restrict');

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('material')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->json('sizes')->nullable();   // ["S","M","L","XL"]
            $table->decimal('weight', 8, 2)->default(0.5); // kg, untuk ongkir

            $table->enum('status', [
                'available',
                'sold_out',
                'preorder',
                'coming_soon',
            ])->default('available');

            $table->boolean('is_limited')->default(false);
            $table->datetime('drop_at')->nullable(); // tanggal rilis drop

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};