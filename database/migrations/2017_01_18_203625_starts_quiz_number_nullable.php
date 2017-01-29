<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StartsQuizNumberNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('starts', function (Blueprint $table) {
            //
            $table->integer('quiz_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        //
        Schema::table('starts', function (Blueprint $table) {
            //
            $table->integer('quiz_number')->change();
        });
    }
}
