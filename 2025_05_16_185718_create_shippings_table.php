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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->enum('size', ['صغير', 'متوسط', 'كبير']);
            $table->enum('shipment_status', ['قيد المراجعة', 'بانتظار الرحلة', 'تم الشحن', 'تم التوصيل', 'ملغاة'])->default('قيد المراجعة');

            $table->foreignId('user_id')->constrained();
            $table->string('national_number_user_to', 30);
            $table->string('phone_user_to', 10);
            $table->string('name_user_to', 100);

            $table->foreignId('trip_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
