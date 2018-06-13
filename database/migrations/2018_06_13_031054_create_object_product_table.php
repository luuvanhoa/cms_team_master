<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_product', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('object_id');
            $table->integer('object_type');
            $table->integer('article_id');
            $table->integer('status');
            $table->dateTime('created_time');
            $table->dateTime('modified_time');
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
        Schema::dropIfExists('object_product');
    }
}
