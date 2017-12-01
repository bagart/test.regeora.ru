<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('smena_id')->unsigned();

            $table->string('ext_id');
            $table->smallInteger('start_minute');//not work with many days route
            $table->smallInteger('end_minute');//not work with many days route
            $table->string('ext_departure_id');
            $table->string('ext_arrival_id');
            $table->integer('distance_meter');
            $table->smallInteger('duration');
            $table->tinyInteger('is_industrial');


            $table
                ->foreign('smena_id')
                ->references('id')
                ->on('smeny')
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
        Schema::dropIfExists('events');
    }
}
