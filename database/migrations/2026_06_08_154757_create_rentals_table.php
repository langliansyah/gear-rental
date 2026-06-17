<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('rental_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->dateTime('rental_date');
            $table->dateTime('return_date_expected');
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->enum('status_payment', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};