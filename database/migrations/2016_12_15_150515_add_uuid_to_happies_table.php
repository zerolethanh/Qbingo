<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuidToHappiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happies', function (Blueprint $table) {
            //
            $table->uuid('happy_uuid')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('happies', function (Blueprint $table) {
            //
            $table->dropColumn('happy_uuid');
//            \Faker\Provider\Uuid::uuid()
        });
    }
}
