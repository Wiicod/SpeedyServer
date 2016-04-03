<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreationTableCommentaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text("description");
            $table->string("status")->default("new");
            $table->string("title");
            $table->integer('player_id')->unsigned()->index()->nullable();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('set null');

        });


        Schema::table('players', function ($table) {
            $table->dropColumn('telephone');
        });

        Schema::table('players', function ($table) {
            $table->string('telephone')->nullable();
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
        Schema::drop('comments');
        Schema::table('players', function ($table) {
            $table->dropColumn('telephone');
        });
        Schema::table('players', function (Blueprint $table) {
            $table->string('telephone')->unique()->nullable();
        });
    }
}
