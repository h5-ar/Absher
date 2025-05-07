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
        Schema::create('item_shippings', function (Blueprint $table) {
            $table->id();
            $table->string('description_item', 255);
            $table->enum('material_value', ['اوراق مهمة', 'زجاج']);
            $table->foreignId('shipping_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_shippings');
    }
};
