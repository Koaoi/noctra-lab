<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->string('reference_image')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('size_preference')->nullable();
            $table->string('color_preference')->nullable();

            $table->enum('status', [
                'pending',
                'reviewing',
                'approved',
                'in_progress',
                'completed',
                'rejected',
            ])->default('pending');

            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 12, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};