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
        Schema::create('feature_vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Feature::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\VehicleModel::class)->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_vehicle_models');
    }
};
