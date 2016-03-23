<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('telephone')->unique()->nullable();
        });


        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float("click");
            $table->boolean("type");
            $table->float("speed");
            $table->integer('player_id')->unsigned()->index();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');

        });


/*
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("name");
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('contries')->onDelete('cascade');

        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('players');
        Schema::drop('scores');
//        Schema::drop('locations');
    }
}
