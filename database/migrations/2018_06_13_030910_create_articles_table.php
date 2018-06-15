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
            $table->mediumText('description')->nullable(true)->default(null);
            $table->string('share_url')->nullable(true)->default(null);
            $table->longText('content');
            $table->string('thumbnail_url')->nullable(true)->default(null);
            $table->string('cate_original')->nullable(true)->default(null);
            $table->string('cate_list')->nullable(true)->default(null);
            $table->integer('status')->nullable(true)->default(0);
            $table->integer('page_views')->nullable(true)->default(0);
            $table->integer('is_comment')->nullable(true)->default(0);
            $table->string('score')->nullable(true)->default(null); // 2013082107151215 => 2013-08-21 07:15:12 15 YYYY-MM-DD-priority (define trước. 1-2-3-5 hight, normal, low... )
            $table->dateTime('created_by')->nullable(true)->default(null);
            $table->dateTime('created_time')->nullable(true)->default(null);
            $table->dateTime('modified_by')->nullable(true)->default(null);
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
        Schema::dropIfExists('articles');
    }
}
