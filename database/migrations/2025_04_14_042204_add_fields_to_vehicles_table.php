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
            $table->integer('order')->default(10)->after('id');
            $table->boolean('is_featured')->default(false)->after('order');
            $table->dropColumn('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('is_featured');
            $table->timestamp('published_at')->nullable()->after('is_active');
        });
    }
};
