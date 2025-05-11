<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->json('name')->change();
        });

        // Update existing records to set the existing name arabic name
        DB::table('colors')->get()->each(function ($color) {
            $color->name = json_encode(['ar' => $color->name]);
            DB::table('colors')->where('id', $color->id)->update(['name' => $color->name]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
