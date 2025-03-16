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
        Schema::table('paths', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->foreign('trip_id')
                  ->references('id')->on('trips')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paths', function (Blueprint $table) {
            //
        });
    }
};
