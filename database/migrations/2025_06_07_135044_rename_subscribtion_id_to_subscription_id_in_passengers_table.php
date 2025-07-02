<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { //if (!Schema::hasTable('subscriptions')) {
        // الطريقة الصحيحة لـ MariaDB 10.4.32
       // DB::statement('
         //   ALTER TABLE passengers
           // CHANGE COLUMN subscribtion_id subscription_id BIGINT UNSIGNED NULL
        //');
    }
    //}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // DB::statement('
         //   ALTER TABLE passengers
           // CHANGE COLUMN subscription_id subscribtion_id BIGINT UNSIGNED NULL
        //');
    }
};
