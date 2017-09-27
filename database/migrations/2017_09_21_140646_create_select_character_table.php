<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('select_character', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('character_id')->unsigned();
            $table->string('select_character');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            if(strtolower(getenv('DB_FOREIGN_KEY_CONSTRAINT') == 'true')) {
                $table->foreign('status_id')->references('id')->on('status');
                $table->foreign('character_id')->references('id')->on('character');
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('select_character');
    }
}
