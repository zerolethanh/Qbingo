<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeHappyPassToPasswordColumnOfTableHappies extends Migration
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
            $table->renameColumn('happy_pass', 'password');
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
            $table->renameColumn('password', 'happy_pass');
        });
    }
}
