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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->year('year')->after('excerpt')->nullable()->comment('Year of manufacture');
        });

        // migrate year from excerpt if it exists
        \App\Models\Vehicle::query()->whereNotNull('excerpt')->each(function ($vehicle) {
            if (preg_match('/\b(\d{4})\b/', $vehicle->excerpt, $matches)) {
                $vehicle->year = $matches[1];
                $vehicle->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
        });
    }
};
