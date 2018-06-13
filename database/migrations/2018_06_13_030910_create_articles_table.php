<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('lead');
            $table->string('description');
            $table->string('share_url');
            $table->longText('content');
            $table->string('thumbnail_url');
            $table->string('cate_original');
            $table->string('cate_list');
            $table->integer('status');
            $table->integer('page_views');
            $table->integer('is_comment');
            $table->string('score'); // 2013082107151215 => 2013-08-21 07:15:12 15 YYYY-MM-DD-priority (define trước. 1-2-3-5 hight, normal, low... )
            $table->dateTime('created_by');
            $table->dateTime('created_time');
            $table->dateTime('modified_by');
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
        Schema::dropIfExists('articles');
    }
}
