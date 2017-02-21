<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_searches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('by_type')->nullable();
            $table->string('by_id')->nullable();
            $table->text('conditions')->nullable();
            $table->text('sql')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_searches');
    }
}
