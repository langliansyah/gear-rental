<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'category_id')->nullOnDelete();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('image_url', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};