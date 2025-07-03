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
        Schema::table('buses', function (Blueprint $table) {
            // 1. إزالة المفتاح الخارجي القديم أولاً
            $table->dropForeign(['Company_id']);

            // 2. إضافة المفتاح الجديد مع خاصية CASCADE
            $table->foreign('Company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buses', function (Blueprint $table) {
             // للتراجع عن التغيير
            $table->dropForeign(['Company_id']);
            
            // إعادة المفتاح القديم بدون CASCADE
            $table->foreign('Company_id')
                  ->references('id')
                  ->on('companies');
        });
    }
};
