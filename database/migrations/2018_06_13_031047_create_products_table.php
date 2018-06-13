<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('sku');
            $table->integer('cate_original');
            $table->string('cate_list');
            $table->string('name');
            $table->string('name_show');
            $table->string('price');
            $table->string('discount_price');
            $table->string('total_discount');
            $table->string('lead');
            $table->longText('description');
            $table->string('thumbnail_url');
            $table->integer('status');
            $table->string('score'); // 2013082107151215 => 2013-08-21 07:15:12 15 YYYY-MM-DD-priority (define trước. 1-2-3-5 hight, normal, low... )
            $table->string('image_list');
            $table->integer('is_buy')->default(1); //  được bán
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
        Schema::dropIfExists('products');
    }
}
