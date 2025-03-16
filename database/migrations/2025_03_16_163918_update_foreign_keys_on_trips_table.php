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
        Schema::table('trips', function (Blueprint $table) {
            Schema::table('trips', function (Blueprint $table) {
                // إزالة المفتاح الأجنبي الحالي
                $table->dropForeign(['bus_id']);

                // إعادة إنشاء المفتاح الأجنبي مع ON DELETE CASCADE
                $table->foreign('bus_id')
                    ->references('id')->on('buses') // يشير إلى جدول buses
                    ->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
