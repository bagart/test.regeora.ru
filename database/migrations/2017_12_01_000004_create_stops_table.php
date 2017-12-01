<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();

            $table->string('ext_id');
            $table->smallInteger('time_minute');
            $table->smallInteger('distanceToNext_meter');
            $table->tinyInteger('kp');


            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');


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
        Schema::dropIfExists('stops');
    }
}
