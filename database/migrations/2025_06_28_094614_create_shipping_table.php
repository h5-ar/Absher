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
        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->string('name_user_to', 100);
            $table->string('phone_to', 10);
            $table->string('national_number_to');
            $table->enum('shipment_status', [
                'قيد المراجعة',
                'بانتظار الرحلة',
                'تم الشحن',
                'تم التوصيل',
                'ملغاة'
            ])->default('قيد المراجعة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
