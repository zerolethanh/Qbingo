<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartsToStartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('starts', function (Blueprint $table) {
            //
            $table->boolean('slot_started')->default(false)->after('hit');
            $table->boolean('quiz_started')->default(false)->after('slot_started');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('starts', function (Blueprint $table) {
            //
            $table->dropColumn('slot_started');
            $table->dropColumn('quiz_started');
        });
    }
}
