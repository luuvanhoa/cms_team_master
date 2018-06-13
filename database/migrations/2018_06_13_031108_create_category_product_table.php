<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            //Info
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('catecode');
            $table->integer('position_header')->default(1);
            $table->integer('show_frontend_header');
            $table->integer('position_footer')->default(1);
            $table->integer('show_frontend_footer');
            $table->string('image');
            $table->boolean('status')->default(1); // 1 show, 0 hidden
            $table->string('description');
            $table->string('options');
            $table->string('meta_description');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->dateTime('created_time');
            $table->dateTime('modified_time');

            // nested
            $table->string('fullcate_parent');
            $table->integer('parent')->default(0);
            $table->integer('left');
            $table->integer('right');
            $table->integer('level')->default(0);

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
        Schema::dropIfExists('category_product');
    }
}
