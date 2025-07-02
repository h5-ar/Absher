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
        Schema::create('path', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['fast', 'interrupted'])->default('interrupted');
            $table->string('from');
            $table->string('to1');
            $table->string('to2')->nullable();
            $table->string('to3')->nullable();
            $table->string('to4')->nullable();
            $table->string('to5')->nullable();
            $table->foreignId('trip_id')->constrained();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('path');
    }
};
