<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, drop the existing foreign key constraint
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
        });

        // Then recreate it with ON DELETE CASCADE
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('plan_id')
                  ->references('id')->on('plans')
                  ->onDelete('cascade'); // This will automatically delete subscriptions when a plan is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
        });

        // Restore original foreign key without cascade
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('plan_id')
                  ->references('id')->on('plans');
        });
    }
};