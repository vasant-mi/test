<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('range', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
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
        Schema::drop('range');
    }
}
