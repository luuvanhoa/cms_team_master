<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_article', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('object_id')->nullable(true)->default(0);
            $table->integer('object_type')->nullable(true)->default(0);
            $table->integer('article_id')->nullable(true)->default(0);
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
        Schema::dropIfExists('object_article');
    }
}
