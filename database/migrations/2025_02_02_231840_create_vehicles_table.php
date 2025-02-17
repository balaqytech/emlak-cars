<?php

use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->string('image');
            $table->string('banner')->nullable();
            $table->text('overview');
            $table->json('features');
            $table->boolean('is_active')->default(true);

            $table->foreignIdFor(VehicleCategory::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(VehicleBrand::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
