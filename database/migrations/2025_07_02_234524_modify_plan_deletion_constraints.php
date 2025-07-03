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
        // 1. First modify passengers -> subscriptions relationship
        Schema::table('passengers', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['subscription_id']);
            
            // Recreate with cascade
            $table->foreign('subscription_id')
                  ->references('id')->on('subscriptions')
                  ->onDelete('cascade');
        });

        // 2. Then modify subscriptions -> plans relationship
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['plan_id']);
            
            // Recreate with cascade
            $table->foreign('plan_id')
                  ->references('id')->on('plans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Reverse passengers change
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->foreign('subscription_id')
                  ->references('id')->on('subscriptions');
        });

        // Reverse subscriptions change
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->foreign('plan_id')
                  ->references('id')->on('plans');
        });
    }
};