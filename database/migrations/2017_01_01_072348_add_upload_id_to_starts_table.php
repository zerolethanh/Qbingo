<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadIdToStartsTable extends Migration
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
            $table->integer('upload_id')->after('quiz_number')->nullable();

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
            $table->dropColumn('upload_id');
        });
    }
}
