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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('last_name');
            $table->integer('seat_number')->unique();
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions');
           $table->string('National_number', 11)->unique();
            $table->string('from', 100);
            $table->string('to', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
