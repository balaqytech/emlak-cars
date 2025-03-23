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
        Schema::create('purchase_applications', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method');
            $table->json('fields');
            $table->json('attachments')->nullable();
            $table->json('vehicle_details');
            $table->json('installment_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_applications');
    }
};
