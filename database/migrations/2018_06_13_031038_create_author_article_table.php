<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_article', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('author_name');
            $table->string('description');
            $table->integer('avatar');
            $table->integer('share_url');
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
        Schema::dropIfExists('author_article');
    }
}
