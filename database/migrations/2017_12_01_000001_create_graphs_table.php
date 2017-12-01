<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graphs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raspvariant_id')->unsigned();

            $table->integer('num');
            $table->integer('nullRun_meter');
            $table->integer('lineRun_meter');
            $table->integer('totalRun_meter');
            $table->smallInteger('nullTime');
            $table->smallInteger('lineTime');
            $table->smallInteger('otsTime');
            $table->smallInteger('totalTime');
            $table->smallInteger('garageOut_minute');
            $table->smallInteger('garageIn_minute');
            $table->smallInteger('lineBegin_minute');
            $table->smallInteger('lineEnd_minute');

            $table
                ->foreign('raspvariant_id')
                ->references('id')
                ->on('raspvariants')
                ->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('graphs');
    }
}
