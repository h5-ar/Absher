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
        Schema::table('companies', function (Blueprint $table) {
            // 1. إزالة القيد القديم أولاً
            $table->dropForeign(['manager_id']);

            // 2. إضافة القيد الجديد مع خاصية CASCADE
            $table->foreign('manager_id')
                ->references('id')
                ->on('managers')
                ->onDelete('cascade') // أو 'set null' إذا أردت الاحتفاظ بالشركات
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
};
