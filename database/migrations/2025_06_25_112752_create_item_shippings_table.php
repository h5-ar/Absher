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
            $table->enum('material_value', ['أدوات كهربائية', 'زجاج', 'أوراق مهمة']);
            $table->string('description_item', 255)->nullable();

            $table->foreignId('shipping_id')->constrained('shippings')->onDelete('cascade');

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