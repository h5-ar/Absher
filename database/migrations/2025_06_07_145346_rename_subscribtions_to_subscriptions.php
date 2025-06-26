<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        // الطريقة الأكثر موثوقية لـ MariaDB
        if (Schema::hasTable('subscribtions')) {
            DB::statement('RENAME TABLE subscribtions TO subscriptions');
        }
    }

    public function down() {}
};
