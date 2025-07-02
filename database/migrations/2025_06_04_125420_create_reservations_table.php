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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->integer('count_seats');
            $table->enum('paidwy', ['cach', 'subscription'])->default('cach');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // تعطيل قيود المفتاح الأجنبي مؤقتًا لمنع مشاكل الحذف
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('reservation');
        Schema::enableForeignKeyConstraints();
    }
};
