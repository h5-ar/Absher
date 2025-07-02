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
        Schema::create('item_shipping', function (Blueprint $table) {
            $table->id();
            $table->string('description_item', 255)->nullable();
            $table->enum('material_value', [
                'أوراق مهمة',
                'أدوات كهربائية',
                'زجاج',
                'ملابس',
                'أدوات طبية'
            ]);
            $table->enum('size', ['صغير', 'متوسط', 'كبير']);
            $table->foreignId('shipping_id')->constrained('shipping')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_shipping');
    }
};
