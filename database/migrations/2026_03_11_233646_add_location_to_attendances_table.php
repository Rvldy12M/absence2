<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah latitude & longitude jika belum ada
            if (!Schema::hasColumn('attendances', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('attendances', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
            // Tambah location
            if (!Schema::hasColumn('attendances', 'location')) {
                $table->string('location')->nullable()->comment('Nama kota/lokasi dari reverse geocoding');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('attendances', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('attendances', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });
    }
};
