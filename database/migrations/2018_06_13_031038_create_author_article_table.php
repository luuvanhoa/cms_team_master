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
            $table->mediumText('description')->nullable(true)->default(null);
            $table->integer('avatar')->nullable(true)->default(null);
            $table->integer('share_url')->nullable(true)->default(null);
            $table->integer('status')->nullable(true)->default(0);
            $table->dateTime('created_time')->nullable(true)->default(null);
            $table->dateTime('modified_time')->nullable(true)->default(null);
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
