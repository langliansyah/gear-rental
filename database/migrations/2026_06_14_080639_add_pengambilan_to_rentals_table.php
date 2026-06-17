<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->enum('metode_pengambilan', ['cod', 'toko'])->default('toko')->after('status_payment');
            $table->text('alamat')->nullable()->after('metode_pengambilan');
            $table->string('toko_tujuan')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['metode_pengambilan', 'alamat', 'toko_tujuan']);
        });
    }
};