<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePassengersForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('passengers', function (Blueprint $table) {
            // إسقاط القيد الخارجي الحالي إذا كان موجوداً
            $table->dropForeign(['reservation_id']);
            
            // إعادة إنشاء القيد مع ON DELETE CASCADE
            $table->foreign('reservation_id')
                  ->references('id')->on('reservations')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropForeign(['reservation_id']);
            
            // استعادة القيد الأصلي بدون ON DELETE CASCADE
            $table->foreign('reservation_id')
                  ->references('id')->on('reservations');
        });

    }
}