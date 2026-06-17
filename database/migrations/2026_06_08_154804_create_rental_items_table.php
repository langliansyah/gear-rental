<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id('rental_item_id');
            $table->foreignId('rental_id')->constrained('rentals', 'rental_id')->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipments', 'equipment_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};