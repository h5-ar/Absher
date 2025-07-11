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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
              $table->string('name', 25);
            $table->string('phone', 10);
            $table->string('email')->unique();
            $table->string('username', 25);
            $table->string('password',25);
            $table->string('Description', 255);
            $table->string('image')->nullable(); // لحفظ مسار الصورة
            $table->foreignId('manager_id')->constrained('managers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
