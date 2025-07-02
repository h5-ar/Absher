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
         Schema::table('shipping', function (Blueprint $table) {
        $table->enum('shipment_status', [
           'قيد المراجعة',
           'جاري الشحن',
           'تم الشحن',
           'تم الاستلام',
        ])->default('قيد المراجعة')->change();
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
