<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHappyCodeToHappiesTable extends Migration
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
            $table->text('happy_code')->after('is_random');
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
            $table->dropColumn('happy_code');
        });
    }
}
