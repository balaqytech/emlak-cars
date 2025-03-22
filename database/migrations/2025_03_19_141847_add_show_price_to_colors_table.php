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
        Schema::table('colors', function (Blueprint $table) {
            $table->boolean('show_price')->default(true)->after('image');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->boolean('show_least_price')->default(true)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn('show_price');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('show_least_price');
        });
    }
};
