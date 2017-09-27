<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->integer('code');
            $table->integer('range_id')->unsigned();
            $table->integer('series_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('rarity_id')->unsigned();
            $table->string('finish');
            $table->string('character_bio');
            $table->string('found_in');
            $table->string('value');
            $table->string('available_only');
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            if(strtolower(getenv('DB_FOREIGN_KEY_CONSTRAINT') == 'true')) {
                $table->foreign('status_id')->references('id')->on('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character');
    }
}
