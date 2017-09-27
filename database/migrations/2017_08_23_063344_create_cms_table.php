<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('seo_url');
            $table->string('cms_desc');
            $table->string('meta_keyword');
            $table->string('meta_desc');
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
        Schema::dropIfExists('cms');
    }
}
