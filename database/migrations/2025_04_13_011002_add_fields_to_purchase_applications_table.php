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
        Schema::table('purchase_applications', function (Blueprint $table) {
            $table->string('status')->default('new')->after('installment_details');
            $table->foreignIdFor(\App\Models\User::class, 'assigned_to')
                ->nullable()
                ->after('status')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_applications', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
            $table->dropColumn('status');
        });
    }
};
