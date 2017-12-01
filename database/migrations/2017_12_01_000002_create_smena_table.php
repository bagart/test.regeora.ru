<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmenaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smeny', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('smena');
            $table->integer('graph_id')->unsigned();


            $table
                ->foreign('graph_id')
                ->references('id')
                ->on('graphs')
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
        Schema::dropIfExists('smeny');
    }
}
